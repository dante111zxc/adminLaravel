<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:category.view')->only('index');
        $this->middleware('can:category.create')->only(['create', 'store']);
        $this->middleware('can:category.edit')->only(['edit', 'update']);
        $this->middleware('can:category.delete')->only('destroy');
    }

    public function index()
    {
        return  view("admin.category.index");
    }

    public function dataTable(){
        return Category::buildDataTable();
    }

    public function create()
    {
        $taxonomies = Category::query()->whereNull('parent_id')->orderBy('id', 'desc')->get();

        return view("admin.category.create", [
            'taxonomies' => $taxonomies
        ]);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => 'required|unique:categories,slug',
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


        $model = new Category();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('category.edit', $model->id)->with('success', 'Tạo danh mục thành công');
    }
    public function edit($id)
    {
        $taxonomies = Category::query()->whereNull('parent_id')->whereNotIn('id', [$id])->orderBy('id', 'desc')->get();
        $taxonomy = Category::query()->findOrFail($id);

        return view("admin.category.edit", [
            'taxonomy' => $taxonomy,
            'taxonomies' => $taxonomies
        ]);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => "required|unique:categories,slug,$id",
            'desc' => 'required',
            'parent_id' => "not_in:$id",
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'desc.required' => 'Mô tả không được bỏ trống',
            'parent_id.not_in' => 'Danh mục phải khác với danh mục hiện tại'
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Category::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('category.edit', $model->id)->with('success', 'Cập nhật danh mục thành công');
    }
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $taxonomy = Category::query()->find($id);
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
