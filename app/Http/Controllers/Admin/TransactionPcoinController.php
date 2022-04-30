<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banking;
use App\Models\Card;
use App\Models\TransactionPcoin;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionPcoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $method_payments = TransactionPcoin::TYPE;
        return view('admin.transaction-pcoin.index', compact('method_payments'));
    }


    public function dataTable (){
        return TransactionPcoin::buildDataTable();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transaction-pcoin.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('admin.transaction-pcoin.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = TransactionPcoin::query()->find($id);
        switch ($transaction->type) {
            case 1 :
                $transaction_data = Card::query()->where([
                    'request_id' => $transaction->request_id
                ])->first();
                break;

            case 2 :
                $transaction_data = $transaction;
                break;

            case 3:
                $transaction_data = Banking::query()->where([
                    'request_id' => $transaction->request_id
                ])->first();
                break;
        }



        $user = User::query()->find($transaction->user_id);
        return view('admin.transaction-pcoin.edit', compact('transaction', 'transaction_data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $transactionInfo = [
            'user_id' => $request->user_id,
            'request_id' => $request->request_id,
            'status' => $request->status,
            'type' => $request->type,
            'note' => $request->note
        ];

        Card::query()->where([
            'tel_code' => $request->tel_code,
            'code' => $request->code,
            'serial' => $request->serial
        ])->whereNotIn('request_id', [$request->request_id])->delete();

        $transaction = TransactionPcoin::query()->find($id);
        $save_transaction = $transaction->fill($transactionInfo)->save();

        //user nạp pcoin bằng thẻ điện thoại
        if ($request->type == 1) {

            $card = Card::query()->where([
                'request_id' => $request->request_id
            ])->first();



            //nếu thể đúng
            if ($request->card_status == 1) {
                $cardInfo = [
                    'amount' => ($request->amount) ? $request->amount : 0,
                    'actually_received' => ($request->actually_received) ? $request->actually_received : 0,
                ];

                //nếu thẻ chưa nạp
                if ($card->status == 0) {
                    $cardInfo['status'] = 1;
                    $card->fill($cardInfo)->save();
                    $user = User::query()->find($request->user_id);
                    $pcoin = $user->pcoin + $request->pcoin;
                    $user->fill(['pcoin' => $pcoin])->save();
                    return redirect()->back()->with('success', 'Cập nhật giao dịch thành công')->withInput();
                }

                //nếu thẻ đã nạp
                if ($card->status == 1) {
                    return redirect()->back()->withErrors(['message' => 'Thẻ đã nạp'])->with('success', 'Cập nhật giao dịch thành công');
                }

                if ( $card->status == 2) {
                    return redirect()->back()->withErrors(['message' => 'Thẻ lỗi'])->with('success', 'Cập nhật giao dịch thành công')->withInput();
                }


            } else {
                if ($request->card_status == 99) {
                    return redirect()->back()->with('success', 'Thẻ đang chờ xử lý')->withInput();
                } else {
                    return redirect()->back()->withErrors(['message' => 'Thẻ lỗi'])->with('success', 'Cập nhật giao dịch thành công')->withInput();
                }

            }
        }

        //nếu user nạp pcoin bằng tk ngân hàng
        if ($request->type == 2) {
            $user = User::query()->find($request->user_id);
            $pcoin = $user->pcoin + $request->pcoin;
            $user->fill(['pcoin' => $pcoin])->save();
        }


        if (!$save_transaction) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('transaction-pcoin.edit', $transaction->id)->with('success', 'Cập nhật giao dịch thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $post = TransactionPcoin::query()->find($id);
                if ($post->delete()) {
                    return response()->json([
                        'type' => 'success',
                        'code' => 200,
                        'message' => 'Xóa bản ghi thành công'
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function checkCardStatus (Request $request){
        if ($request->ajax() && $request->method('POST')) {
            $input['telco'] = $request->telco;
            $input['code'] = $request->code;
            $input['serial'] = $request->serial;
            $input['amount'] = $request->amount;
            $input['request_id'] = $request->request_id;
            $input['partner_id'] = Card::$partner_id;
            $input['command'] = 'check';
            $input['sign'] = md5(Card::$partner_key. $request->code . 'check' . Card::$partner_id . $request->request_id . $request->serial . $request->telco);
            return response()->json(Card::checkCard($input));
        };
    }
}
