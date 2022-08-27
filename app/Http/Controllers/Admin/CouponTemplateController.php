<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:coupontemplate.view')->only('index');
        $this->middleware('can:coupontemplate.create')->only(['create', 'store']);
        $this->middleware('can:coupontemplate.edit')->only(['edit', 'update']);
        $this->middleware('can:coupontemplate.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view("admin.coupon-template.index");
    }

    public function dataTable(){
        return CouponTemplate::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon-template.create');
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
            'type' => 'required|integer|in:1,2',
            'discount' => 'required|integer'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'type.required' => 'Kiểu giảm không được bỏ trống',
            'type.integer' => 'Kiểu giảm giá phải là 1 số',
            'type.in' => 'Kiểu giảm giá theo tỷ lệ hoặc VND',
            'discount.required' => 'Số tiền giảm giá không được bỏ trống',
            'discount.integer' => 'Số tiền giảm giá phải là số',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new CouponTemplate();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('coupon-template.edit', $model->id)->with('success', 'Tạo loại mã giảm giá thành công');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $couponTemplate = CouponTemplate::query()->findOrFail($id);
        return view('admin.coupon-template.edit', compact('couponTemplate'));
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
            'type' => 'required|integer|in:1,2',
            'discount' => 'required|integer'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'type.required' => 'Kiểu giảm không được bỏ trống',
            'type.integer' => 'Kiểu giảm giá phải là 1 số',
            'type.in' => 'Kiểu giảm giá theo tỷ lệ hoặc VND',
            'discount.required' => 'Số tiền giảm giá không được bỏ trống',
            'discount.integer' => 'Số tiền giảm giá phải là số',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = CouponTemplate::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('coupon-template.edit', $model->id)->with('success', 'Cập nhật loại mã giảm giá thành công');
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
