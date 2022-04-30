<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:page.view')->only('index');
        $this->middleware('can:page.create')->only(['create', 'store']);
        $this->middleware('can:page.edit')->only(['edit', 'update']);
        $this->middleware('can:page.delete')->only('destroy');
    }

    public function index()
    {
        return  view("admin.page.index");
    }

    public function dataTable ()
    {
        return Page::buildDataTable();
    }

    public function create()
    {
        return view("admin.page.create");
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => 'required|unique:pages,slug',
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



        $model = new Page();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('page.edit', $model->id )->with('success', 'Tạo trang thành công');
    }

    public function edit($id)
    {
        $page = Page::query()->findOrFail($id);
        return view("admin.page.edit", compact('page'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => "required|unique:pages,slug,$id",
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


        $model = Page::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('page.edit', $model->id )->with('success', 'Cập nhật trang thành công');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $post = Page::query()->find($id);
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
