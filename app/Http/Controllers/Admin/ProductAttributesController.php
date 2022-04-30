<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\Validator;

class ProductAttributesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:product-attributes.view')->only('index');
        $this->middleware('can:product-attributes.create')->only(['create', 'store']);
        $this->middleware('can:product-attributes.edit')->only(['edit', 'update']);
        $this->middleware('can:product-attributes.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product-attributes.index');
    }
    public function dataTable (){
        return ProductAttributes::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-attributes.create');
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
            'slug' => 'required|unique:product_attributes,slug',
            'type' => 'required|alpha_dash'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'type.required' => 'Loại thuộc tính không được bỏ trống',
            'type.alpha_dash' => 'Loại thuộc tính chỉ chấp nhận ký tự chữ, số, dấu gạch ngang và dấu gạch dưới'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new ProductAttributes();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('product-attributes.edit', $model->id)->with('success', 'Tạo loại thuộc tính sản phẩm thành công');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attributesType = ProductAttributes::query()->find($id);
        return view('admin.product-attributes.edit', compact('attributesType'));
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
            'slug' => "required|unique:product_attributes,slug,$id",
            'type' => 'required|alpha_dash'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'type.required' => 'Loại thuộc tính không được bỏ trống',
            'type.alpha_dash' => 'Loại thuộc tính chỉ chấp nhận ký tự chữ, số, dấu gạch ngang và dấu gạch dưới'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = ProductAttributes::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('product-attributes.edit', $model->id)->with('success', 'Cập nhật loại thuộc tính sản phẩm thành công');
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
            $taxonomy = ProductAttributes::query()->find($id);
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

    /**
     * Danh sách các thuộc tính con
     *
     * @param  int  $attribute_id
     * @return \Illuminate\Http\Response
     */
    public function attributesIndex ($attribute_id){
        return view('admin.product-attributes.attributes.index', compact('attribute_id'));
    }
    public function attributesCreate ($attribute_id){
        $parent = ProductAttributes::query()->find($attribute_id);
        return view('admin.product-attributes.attributes.create', compact('attribute_id', 'parent'));
    }
    public function attributesDataTable ($AttributeID) {
        $parent = ProductAttributes::query()->find($AttributeID);
        return ProductAttributes::buildDataTableAttributes($AttributeID, $parent->type);
    }

    public function attributesStore (Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => 'required|unique:product_attributes,slug',
            'type' => 'required|alpha_dash',
            'parent_id' => 'required'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'type.required' => 'Loại thuộc tính không được bỏ trống',
            'type.alpha_dash' => 'Loại thuộc tính chỉ chấp nhận ký tự chữ, số, dấu gạch ngang và dấu gạch dưới',
            'parent_id' => 'Thuộc tính cha không được bỏ trống'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new ProductAttributes();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('attributes_edit', ['id' => $request->parent_id, 'attribute_id' => $model->id])->with('success', 'Tạo thuộc tính sản phẩm thành công');
    }

    public function attributesUpdate (Request $request, $id, $attribute_id){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => "required|unique:product_attributes,slug, $attribute_id",
            'type' => 'required|alpha_dash',
            'parent_id' => 'required'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'type.required' => 'Loại thuộc tính không được bỏ trống',
            'type.alpha_dash' => 'Loại thuộc tính chỉ chấp nhận ký tự chữ, số, dấu gạch ngang và dấu gạch dưới',
            'parent_id' => 'Thuộc tính cha không được bỏ trống'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = ProductAttributes::query()->find($attribute_id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('attributes_edit', ['id' => $id, 'attribute_id' => $attribute_id])->with('success', 'Cập nhật thuộc tính sản phẩm thành công');
    }
    public function attributesEdit ($id, $attribute_id) {
        $attributes = ProductAttributes::query()->find($attribute_id);
        $parent = ProductAttributes::query()->find($id);
        return view('admin.product-attributes.attributes.edit', compact('attributes', 'id', 'parent'));
    }
}
