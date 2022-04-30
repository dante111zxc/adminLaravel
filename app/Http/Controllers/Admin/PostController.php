<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:post.view')->only('index');
        $this->middleware('can:post.create')->only(['create', 'store']);
        $this->middleware('can:post.edit')->only(['edit', 'update']);
        $this->middleware('can:post.delete')->only('destroy');
    }

    public function index()
    {
        return  view("admin.post.index");
    }

    public function dataTable ()
    {
        return Post::buildDataTable();
    }

    public function create()
    {
        $category = Category::query()->whereNull('parent_id')->where(['status' => 1])->orderBy('id', 'desc')->get();

        $tag = Tag::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->get();


        return view("admin.post.create",[
            'category' => $category,
            'tag' => $tag
        ]);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => 'required|unique:posts,slug',
            'desc' => 'required',
            'category_id' => 'required'

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'desc.required' => 'Mô tả không được bỏ trống',
            'category_id.required' => 'Danh mục không được bỏ trống',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $model = new Post();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        $model->category()->attach($request->input('category_id'));
        $model->tag()->attach($request->input('tag_id'));

        return redirect()->route('post.edit', $model->id )->with('success', 'Tạo bài viết thành công');
    }

    public function edit($id)
    {
        $post = Post::query()->findOrFail($id);
        $category = Category::query()->whereNull('parent_id')
            ->where([
                'status' => 1
        ])->orderBy('id', 'desc')->get();

        $tag = Tag::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->get();

        $idCategory = ($post->category) ? array_column($post->category->toArray(), 'id') : null;
        $idTag = ($post->tag) ? array_column($post->tag->toArray(), 'id') : null;


        return view("admin.post.edit", [
            'post' => $post,
            'category' => $category,
            'tag' => $tag,
            'id_category' => $idCategory,
            'id_tag' => $idTag
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => "required|unique:posts,slug,$id",
            'desc' => 'required',
            'category_id' => 'required'
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'desc.required' => 'Mô tả không được bỏ trống',
            'category_id.required' => 'Danh mục không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $post = Post::query()->find($id);
        $post->fill($request->all());
        $save = $post->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        $post->category()->sync($request->input('category_id'));
        $post->tag()->sync($request->input('tag_id'));

        return redirect()->route('post.edit', $post->id )->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $post = Post::query()->find($id);
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
}
