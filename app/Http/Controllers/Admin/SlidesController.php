<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slides;
use Illuminate\Support\Facades\Validator;
class SlidesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:slides.view')->only('index');
        $this->middleware('can:slides.create')->only(['create', 'store']);
        $this->middleware('can:slides.edit')->only(['edit', 'update']);
        $this->middleware('can:slides.delete')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view("admin.slides.index");
    }


    public function dataTable(){
        return Slides::buildDataTable();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slides.create');
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
            'url' => 'required',
            'thumbnail' => 'required',
            'order' => 'required',

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'url.required' => 'Url không được bỏ trống',
            'thumbnail.required' => 'Hình ảnh không được bỏ trống',
            'order.required' => 'Thứ tự không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $model = new Slides();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('slides.edit', $model->id)->with('success', 'Tạo slide thành công');
    }


    public function edit($id)
    {
        $slides = Slides::query()->find($id);
        return view('admin.slides.edit', compact('slides'));
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
            'url' => 'required',
            'thumbnail' => 'required',
            'order' => 'required',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'url.required' => 'Url không được bỏ trống',
            'thumbnail.required' => 'Hình ảnh không được bỏ trống',
            'order.required' => 'Thứ tự không được bỏ trống',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Slides::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('slides.edit', $model->id)->with('success', 'Cập nhật slide thành công');
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
            $taxonomy = Slides::query()->find($id);
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
