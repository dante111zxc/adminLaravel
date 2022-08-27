<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:coupon.view')->only('index');
        $this->middleware('can:coupon.create')->only(['create', 'store']);
        $this->middleware('can:coupon.edit')->only(['edit', 'update']);
        $this->middleware('can:coupon.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.coupon.index");
    }

    public function dataTable(){
        return Coupon::buildDataTable();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couponTemplate = CouponTemplate::all();
        return view('admin.coupon.create', compact('couponTemplate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'code' => 'required|unique:coupons,code',
            'coupon_template_id' => 'required|integer',
            'number_of_uses' => 'required|integer',

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'code.required' => 'Mã giảm giá không được bỏ trống',
            'code.unique' => 'Mã giảm giá đã tồn tại',
            'coupon_template_id.required' => 'Loại giảm giá không được bỏ trống',
            'number_of_uses.required' => 'Số lần sử dụng không được bỏ trống'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new Coupon();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('coupon.edit', $model->id)->with('success', 'Tạo mã giảm giá thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::query()->findOrFail($id);
        $couponTemplate = CouponTemplate::all();
        return view('admin.coupon.edit', compact('couponTemplate', 'coupon'));
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
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'code' => 'required|unique:coupons,code,'. $id,
            'coupon_template_id' => 'required|integer',
            'number_of_uses' => 'required|integer',

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'code.required' => 'Mã giảm giá không được bỏ trống',
            'code.unique' => 'Mã giảm giá đã tồn tại',
            'coupon_template_id.required' => 'Loại giảm giá không được bỏ trống',
            'number_of_uses.required' => 'Số lần sử dụng không được bỏ trống'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Coupon::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('coupon.edit', $model->id)->with('success', 'Cập nhật mã giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
