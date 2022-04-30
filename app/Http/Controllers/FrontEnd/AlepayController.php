<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Banking;
use App\Models\MethodPayments;
use App\Models\TransactionPcoin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;
use phpseclib3\Crypt\RSA;

class AlepayController extends Controller
{



    public function payCoin (Request $request){
        return view('public.user.pay-coin-by-bank');
    }

    public function payCoinSubmit (Request $request){
        $requestId = Str::random(10);
        $user = $request->user();
        $validatorUser = Validator::make($user->toArray(), [
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'email' => 'required|email'
        ], [
            'phone.required' => 'Vui lòng cập nhật số điện thoại để sử dụng tính năng này',
            'address.required' => 'Vui lòng cập nhật địa chỉ để sử dụng tính năng này',
            'name.required' => 'Vui lòng cập nhật họ tên để sử dụng tính năng này',
            'email.required' => 'Vui lòng cập nhật email để sử dụng tính năng này',
            'email.email' => 'Email không đúng định dạng',

        ]);
        $validatorAmount = Validator::make($request->all(),[
            'pcoin' => 'required|numeric',
        ],[
            'required' => 'Số Pcoin không được bỏ trống',
            'numeric' => 'Số Pcoin nhập vào không đúng'
        ]);
        if ($validatorUser->fails()) {
            return redirect()->back()->withErrors($validatorUser);
        }

        if ($validatorAmount->fails()) {
            return redirect()->back()->withErrors($validatorAmount)->withInput();
        }
        DB::beginTransaction();
        try {

            //tạo đơn hàng mới
            $transaction_pcoin = TransactionPcoin::query()->create([
                'user_id' => $user->id,
                'request_id' => $requestId,
                'status' => 0,
                'type' => 3,
                'note' => 'Thanh toán trực tuyến qua Alepay',
            ]);

            //lưu thông tin chuyển khoản
            $bank_data = Banking::query()->create([
                'request_id' => $requestId,
                'user_id' => $user->id,
                'amount' => intval(preg_replace('@\D+@', '', $request->input('pcoin'))),
                'order_code' => date('dmY') . '_' . uniqid(),
                'total_item' => 1,
                'status' => 0,
            ]);


            //gửi thông tin thanh toán đến api alepay
            $dataAlepay = [
                'cancelUrl' => route('alepay_cancel_url', ['id' => $bank_data->id]),
                'returnUrl' => route('alepay_return_url'),
                'amount' => intval(preg_replace('@\D+@', '', $request->input('pcoin'))),
                'orderCode' => $bank_data->order_code,
                'currency' => 'VND',
                'orderDescription' => 'Thanh toán Pcoin bằng GD trực tuyến qua cổng Alepay',
                'totalItem' => 1,
                'checkoutType' => 3,
                'buyerName' => $user->name,
                'buyerEmail' => $user->email,
                'buyerPhone' => $user->phone,
                'buyerAddress' => $user->address,
                'buyerCity' => 'Hà Nội',
                'buyerCountry' => 'Việt Nam',
                'paymentHours' => 0.15,
                'allowDomestic' => true
            ];

            $alepay_result = $this->sendRequestToAlepay(env('ALEPAY_URL'). 'request-payment', $dataAlepay);
            if ($alepay_result['code'] == '000') {
                $bank_data->fill([
                    'transaction_code' => $alepay_result['transactionCode'],
                ])->save();
                DB::commit();
                return redirect($alepay_result['checkoutUrl']);
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors('Có lỗi xảy ra, vui lòng thử lại sau')->withInput();
            }


        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors('Có lỗi xảy ra, vui lòng thử lại sau')->withInput();
        }

    }

    public function returnUrl (Request $request){
        DB::beginTransaction();
        $link = DB::table('link_expried')->where([
            'url' => $request->route()->uri() . '?'. $request->getQueryString(),
            'is_click' => 1
        ])->first();

        if (!$link) {

            DB::table('link_expried')->insert([
                'url' => $request->route()->uri() . '?'. $request->getQueryString(),
                'is_click' => 1
            ]);
            if ($request->input('errorCode') == '000') {
                $transaction_code = $request->input('transactionCode');

                //lấy thông tin giao dịch từ alepay
                $req = [
                    'transactionCode' => $transaction_code
                ];
                $transactionInfo = $this->sendRequestToAlepay(env('ALEPAY_URL') . 'get-transaction-info', $req);
                $banking = Banking::query()->where([
                    'transaction_code' => $transaction_code
                ])->first();
                $transactionPcoin = TransactionPcoin::query()->where([
                    'request_id' => $banking->request_id
                ])->first();
                $transactionPcoin->fill([
                    'status' => 1,
                    'note' => $transactionInfo['reason']
                ])->save();
                $banking->fill(['status' => 1])->save();


                //cập nhật pcoin cho user
                $user = $request->user('web');
                $user->fill([
                    'pcoin' => $user->pcoin + $transactionInfo['amount']
                ])->save();
                $transactionData = [
                    'amount' => $banking->amount,
                    'request_id' => $banking->request_id,
                    'bank_name' => $transactionInfo['bankName'],
                    'method' => $transactionInfo['method'],
                    'payer_fee' => $transactionInfo['payerFee'],
                    'email' => $transactionInfo['buyerEmail'],
                    'phone' => $transactionInfo['buyerPhone'],
                    'desc' => $transactionInfo['reason'],
                    'transaction_time' => $transactionInfo['transactionTime']
                ];

                DB::commit();
                return view('public.user.pay-coin-success', compact('transactionData'));
            } else {
                DB::rollBack();
                return view('public.user.pay-coin-failed');
            }
        } else {
            DB::rollBack();
            return abort(419);
        }


    }


    public function cancelUrl (Request $request, $id) {
        DB::beginTransaction();
        $link = DB::table('link_expried')->where([
            'url' => $request->getPathInfo(),
            'is_click' => 1
        ])->first();
        if (!$link) {

            DB::table('link_expried')->insert([
                'url' => $request->getPathInfo(),
                'is_click' => 1
            ]);
            $banking = Banking::query()->find($id);

            $transactionPcoin = TransactionPcoin::query()->where([
                'request_id' => $banking->request_id
            ])->first();

            $transactionPcoin->fill(['status' => 2])->save();
            DB::commit();
            return view('public.user.pay-coin-failed');
        } else {
            DB::rollBack();
            return abort(419);
        }

    }

    public function encryptData ($string){
        $rsa = RSA::load(env('ALEPAY_ENCRYPT_KEY'));
        $output = $rsa->withPadding(RSA::ENCRYPTION_PKCS1)->encrypt($string);
        return base64_encode($output);
    }

    public function deCryptData(Request $request) {
        $ciphertext = base64_decode($request->all());
        $rsa = RSA::load(env('ALEPAY_ENCRYPT_KEY'));
        $output = $rsa->withPadding(RSA::ENCRYPTION_PKCS1)->decrypt($ciphertext);
        return $output;
    }

    private static function makeSignature ($data, $hash_key) {
        $hash_data = '';
        ksort($data);
        $is_first_key = true;
        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            if (!$is_first_key) {
                $hash_data .= '&' . $key . '=' . $value;
            } else {
                $hash_data .= $key . '=' . $value;
                $is_first_key = false;
            }
        }

        $signature = hash_hmac('sha256', $hash_data, $hash_key);
        return $signature;
    }

    private function sendRequestToAlepay ($url, $data) {

        $data['tokenKey'] = env('ALEPAY_API_KEY');
        $signature = $this->makeSignature($data, env('ALEPAY_CHECKSUM_KEY'));
        $data['signature'] = $signature;
        $response = Http::acceptJson()->withHeaders([
            'Content-Length: ' . strlen(json_encode($data))
        ])->withoutVerifying()->post($url, $data)->json();
        return $response;
    }
}
