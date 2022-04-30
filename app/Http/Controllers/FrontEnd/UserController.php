<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

use App\Models\Card;
use App\Models\MethodPayments;
use App\Models\Orders;
use App\Models\Reviews;
use App\Models\TransactionPcoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $api_charge_card_money;
    protected $command;
    protected $partner_id;
    protected $partner_key;

    public function __construct()
    {
        $this->api_charge_card_money = Card::$api_charge_card_money;
        $this->partner_id = Card::$partner_id;
        $this->partner_key = Card::$partner_key;
    }

    public function profile (Request $request){
        $user = $request->user();
        $method_payment = MethodPayments::query()->where('status', 1)->get();
        $totalAmount = Orders::getTotalOrderAmountByUserId($user->id);
        return view('public.user.profile', compact('user', 'method_payment', 'totalAmount'));
    }
    public function updateProfile (Request $request){
       if ($request->ajax() && $request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'email' => 'required|email',
                ],[
                    'name.required' => 'Tên không được bỏ trống',
                    'phone.required' => 'Số điện thoại không được bỏ trống',
                    'address.required' => 'Địa chỉ không được bỏ trống',
                    'email.required' => 'Email không được bỏ trống',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'code' => 403,
                        'type' => 'error',
                        'message' => 'Vui lòng kiểm tra lại dữ liệu đã nhập',
                        'validatorMessage' => $validator->getMessageBag()->getMessages()
                    ]);

                }

                $input = $request->all();
                unset($input['email']);

                $user = $request->user();
                $user->fill( $input );
                $user->save();


                return response()->json([
                    'code' => 200,
                    'type' => 'success',
                    'message' => 'Cập nhật thông tin tài khoản thành công',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'code' => 400,
                    'type' => 'error',
                    'message' => 'Có lỗi xảy ra',
                ]);
            }
       }

    }
    public function updatePassword(Request $request){
        if ($request->ajax() && $request->isMethod('post')) {
            $user = $request->user();
            try {
                $validator = Validator::make($request->all(), [
                    'password' => 'required',
                    'new_password' => 'required|string|min:8|same:confirm',
                ],[
                    'password.require' => 'Mật khẩu hiện tại không được bỏ trống' ,
                    'new_password.required' => 'Mật khẩu không được bỏ trống',
                    'new_password.string' => 'Mật khẩu không được chứa ký tự đặc biệt',
                    'new_password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
                    'new_password.same' => 'Mật khẩu xác nhận không khớp',
                ]);

                if ($validator->fails()) {

                    return response()->json([
                        'code' => 403,
                        'type' => 'error',
                        'message' => 'Vui lòng kiểm tra lại dữ liệu đã nhập',
                        'validatorMessage' => $validator->getMessageBag()->getMessages()
                    ]);
                }

                if ( !Hash::check($request->input('password'), Auth::user()->password)) {
                    $validator->errors()->add('password', 'Bạn đã nhập sai mật khẩu cũ');
                    return response()->json([
                        'code' => 403,
                        'type' => 'error',
                        'message' => 'Bạn đã nhập sai mật khẩu cũ',
                        'validatorMessage' => $validator->getMessageBag()->getMessages()
                    ]);

                };

                $user->password = Hash::make($request->input('new_password'));
                $save = $user->save();
                if ($save) {
                    return response()->json([
                        'code' => 200,
                        'type' => 'success',
                        'message' => 'Đổi mật khẩu thành công',
                    ]);
                } else {
                    return response()->json([
                        'code' => 400,
                        'type' => 'error',
                        'message' => 'Đổi mật khẩu thất bại',
                    ]);
                }



            } catch (\Exception $exception) {
                return response()->json([
                    'code' => 400,
                    'type' => 'error',
                    'message' => 'Có lỗi xảy ra',
                ]);
            }
        }
    }
    public function payCoinByCardPhone (Request $request){
        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'card_type' => 'required',
                    'card_price' => 'required|int',
                    'card_serial' => 'required|min:12|max:15',
                    'card_code' => 'required|min:12|max:15',
                ],[
                    'card_type.required' => 'Bạn chưa chọn loại thẻ',
                    'card_price.required' => 'Bạn chưa chọn mệnh giá',
                    'card_price.int' => 'Mệnh giá thẻ sai',
                    'card_serial.required' => 'Bạn chưa nhập Serial thẻ',
                    'card_serial.min' => 'Serial thẻ có tối thiểu 14 ký tự',
                    'card_serial.max' => 'Serial thẻ có tối đa 14 ký tự',
                    'card_code.min' => 'Mã thẻ có tối thiểu 15 ký tự',
                    'card_code.max' => 'Mã thẻ có tối đa 15 ký tự',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'code' => 403,
                        'type' => 'error',
                        'message' => 'Vui lòng kiểm tra lại dữ liệu đã nhập',
                        'validatorMessage' => $validator->getMessageBag()->getMessages()
                    ]);
                }
                $requestId = Str::random(10);
                $sign = md5($this->partner_key . $request->input('card_code') . 'charging' . $this->partner_id . $requestId . $request->input('card_serial') . $request->input('card_type'));
                $dataForm = [
                    'telco' => $request->input('card_type'),
                    'code' => $request->input('card_code'),
                    'serial' => $request->input('card_serial'),
                    'amount' => $request->input('card_price'),
                    'partner_id' => $this->partner_id,
                    'sign' => $sign,
                    'command' => 'charging',
                    'request_id' => $requestId,
                ];



                $data = Card::chargingCard($dataForm);
                $card = Card::createCard($request->all(), $requestId, 0);
                if ($card->request_id) {
                    $transaction = TransactionPcoin::query()->create([
                        'user_id' => Auth::user()->id,
                        'request_id' => $requestId,
                        'status' => 0,
                        'type' => 1,
                        'note' => 'Nạp Pcoin bằng thẻ điện thoại'
                    ]);

                    if (!empty($transaction)) {
                        Mail::to(env('MAIL_ADMIN'))
                            ->send(new \App\Mail\TransactionPcoin($transaction, Auth::user()));
                    }
                    if ($data['status'] == 99 || $data['status'] == 1){
                        return response()->json([
                            'type' => 'success',
                            'message' => 'Gửi thẻ lên hệ thống thành công, chúng tôi đang kiểm tra mã thẻ',
                            'code' => 200
                        ]);
                    } else {
                        return response()->json([
                            'type' => 'error',
                            'message' => $data['message'],
                            'code' => 400
                        ]);
                    }
                } else {
                    return response()->json([
                        'type' => 'error',
                        'message' => 'Không gửi đc thẻ lên hệ thống, vui lòng thử lại hoặc liên hệ admin',
                        'code' => 400
                    ]);
                }


            } catch (\Exception $exception) {
                return response()->json([
                    'code' => 400,
                    'type' => 'error',
                    'message' => 'Có lỗi xảy ra'
                ]);
            }
        }
    }
    public function payCoinByCardBankingView (Request $request, $bank_id){
        $bank = MethodPayments::query()->where([
            'id' => $bank_id,
            'status' => 1
        ])->first();
        if (!empty($bank)) return view('public.user.pay-coin-by-bank', compact('bank'));
        else return redirect()->route('home');

//        $storeImage = storeImage($request);
//        $transaction = TransactionPcoin::query()->create([
//            'user_id' => Auth::user()->id,
//            'request_id' => Str::random(10),
//            'status' => 0,
//            'type' => 2,
//            'note' => 'Nạp Pcoin bằng phương thức CK ngân hàng',
//            'thumbnail' => $storeImage['data']
//        ]);
//        $result = $storeImage;
//        $result['transaction'] = $transaction;
//        return response()->json($result);
    }
    public function payCoinByCardBanking (Request $request, $bank_id){
        $bank = MethodPayments::query()->findOrFail($bank_id);

        dd($bank);

    }
    public function transactionHistoryByCard (){
        return TransactionPcoin::transactionHistoryPayCoinByCard();
    }
    public function transactionHistoryByBank (){
        return TransactionPcoin::transactionHistoryPayCoinByBank();
    }
    public function historyOrder (){
        return Orders::historyOrder();
    }
    public function review (Request $request) {
        if ($request->ajax() && $request->method('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'content' => 'required|min:6',
                ],[
                    'content.required' => 'Vui lòng điền nôi dung review',
                    'content.min' => 'Nội dung phải có tối thiểu 6 ký tự'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'code' => 403,
                        'type' => 'error',
                        'message' => 'Vui lòng kiểm tra lại dữ liệu đã nhập',
                        'validatorMessage' => $validator->getMessageBag()->getMessages()
                    ]);
                }
                $args['ip'] = $request->ip();
                $args = array_merge($args, $request->all());

                //check xem da danh gia chua
                //neu danh gia roi thi k cho danh gia nua
                $review_content = Reviews::query()->where([
                    'type' => $request->input('type'),
                    'post_id' => $request->input('post_id'),
                    'ip' => $args['ip']
                ])->count();

                if ($review_content > 0) {
                    unset($args['vote']);
                }

                $reviews = new Reviews();
                $save = $reviews->fill($args)->save();
                if ($save) {
                    return response()->json([
                        'code' => 200,
                        'type' => 'success',
                        'message' => 'Cảm ơn bạn đã gửi bình luận cho chúng tôi'
                    ]);
                }



            } catch (\Exception $exception) {
                return response()->json([
                    'code' => 400,
                    'type' => 'error',
                    'message' => 'Bình luận thất bại',
                ]);
            }
        }

    }

}
