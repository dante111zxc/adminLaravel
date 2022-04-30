<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post (Request $request){
        $post = Post::query()->findOrFail($request->route('id'));
        $category = $post->category;
        $categoryId = array_map(function ($item){
            return $item['id'];
        }, $category->toArray());
        $postRelated = Category::postRelated($categoryId, $post->id);


        //breadcrumb
        $breadcrumb = array();
        array_push($breadcrumb, [
            'title' => 'Trang chủ',
            'url' => url('/')
        ]);
        if (!empty($category)) {
            foreach ($category as $item) {
                array_push($breadcrumb, [
                    'title' => $item->title,
                    'url' => route('category', ['id' => $item->id, 'slug' => $item->slug])
                ]);
            }
        }

        //Seo meta
        $dataSeo['site_name'] = !empty($post->meta_title) ? $post->meta_title : $post->title;
        $dataSeo['meta_desc'] = !empty($post->meta_desc) ? $post->meta_desc : $post->desc;
        $dataSeo['keyword_seo'] = !empty($post->meta_keyword) ? $post->meta_keyword : $post->title;
        $dataSeo['news_keywords'] = !empty($post->meta_keyword) ? $post->meta_keyword : $post->title;
        $dataSeo['robots'] = !empty($post->robots) ? 'index, follow' : 'noindex, nofollow';

        return view('public.post.index', compact('post','postRelated', 'breadcrumb', 'dataSeo'));
    }
}
