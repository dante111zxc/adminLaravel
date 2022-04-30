<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:tag.view')->only('index');
        $this->middleware('can:tag.create')->only(['create', 'store']);
        $this->middleware('can:tag.edit')->only(['edit', 'update']);
        $this->middleware('can:tag.delete')->only('destroy');
    }

    public function index()
    {
        return  view("admin.tag.index");
    }
    public function dataTable(){
        return Tag::buildDataTable();
    }
    public function create()
    {

        return view("admin.tag.create");

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => 'required|unique:tags,slug',
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


        $model = new Tag();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('tag.edit', $model->id)->with('success', 'Tạo tag thành công');
    }
    public function edit($id)
    {
        $taxonomy = Tag::query()->findOrFail($id);

        return view("admin.tag.edit", [
            'taxonomy' => $taxonomy,
        ]);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => "required|unique:tags,slug,$id",
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

        $model = Tag::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('tag.edit', $model->id)->with('success', 'Cập nhật thẻ tag thành công');
    }
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $taxonomy = Tag::query()->find($id);
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
