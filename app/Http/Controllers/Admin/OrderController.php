<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderUser;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:order.view')->only('index');
        $this->middleware('can:order.create')->only(['create', 'store']);
        $this->middleware('can:order.edit')->only(['edit', 'update']);
        $this->middleware('can:order.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index');
    }


    public function dataTable ()
    {
        return Orders::buildDataTable();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Orders::query()->findOrFail($id);
        $accInfo = json_decode($order->acc_info);
        $orderDetail = Orders::orderDetail($order->id);

        $saleVipMember = '0%';
        if ($order->is_vip_member) {
            $saleVipMember = getSalePercentByUserId($order->user_id);
        }

        return view('admin.order.edit', compact('order', 'accInfo', 'orderDetail', 'saleVipMember'));
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
        $validator = Validator::make($request->all(), [
            'email_to' => 'email'
        ],[
            'email_to.email' => 'Email sai định dạng'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Orders::query()->find($id);
        $email_has_send = $request->input('email_has_send');
        $model->fill($request->all());
        if (!empty($request->input('email_to')) && $model->email_has_send == 0) {
            Mail::to($request->input('email_to'))->cc(env('MAIL_ADMIN'))
                ->send(new OrderUser($model));
            if (Mail::failures()) {
                return redirect()->back()->withErrors(['message' => 'Gửi email cho khách hàng thất bại'])->withInput();
            }

            $email_has_send = 1;
        }
        $model->fill($request->all());
        $model->fill(['email_has_send' => $email_has_send])->save();
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('order.edit', $model->id )->with('success', 'Cập nhật đơn hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $post = Orders::query()->find($id);
            $delete = $post->delete();
            if (!$delete) {
                return response()->json([
                    'type' => 'error',
                    'code' => 500,
                    'message' => 'Có lỗi xảy ra'
                ]);
            }

            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Xóa bản ghi thành công'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'code' => 500,
            'message' => 'Có lỗi xảy ra'
        ]);
    }
}
