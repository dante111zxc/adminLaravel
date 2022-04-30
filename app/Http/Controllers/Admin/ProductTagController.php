<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductTagController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:product-tag.view')->only('index');
        $this->middleware('can:product-tag.create')->only(['create', 'store']);
        $this->middleware('can:product-tag.edit')->only(['edit', 'update']);
        $this->middleware('can:product-tag.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view("admin.product-tag.index");
    }


    public function dataTable(){
        return ProductTag::buildDataTable();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-tag.create');
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
            'slug' => 'required|unique:product_tags,slug',
            'desc' => 'required'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'desc.required' => 'Mô tả không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $model = new ProductTag();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('product-tag.edit', $model->id)->with('success', 'Tạo tag sản phẩm thành công');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taxonomy = ProductTag::query()->findOrFail($id);

        return view("admin.product-tag.edit", [
            'taxonomy' => $taxonomy,
        ]);
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
            'slug' => "required|unique:product_tags,slug,$id",
            'desc' => 'required',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'desc.required' => 'Mô tả không được bỏ trống',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = ProductTag::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('product-tag.edit', $model->id)->with('success', 'Cập nhật thẻ tag sản phẩm thành công');
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
            $taxonomy = ProductTag::query()->find($id);
            $delete = $taxonomy->delete();
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
