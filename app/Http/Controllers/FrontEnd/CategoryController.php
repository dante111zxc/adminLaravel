<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category (Request $request){
        $category = Category::query()->findOrFail($request->route('id'));
        $posts = $category->posts()->paginate(12);


        //Seo meta
        $dataSeo['site_name'] = !empty($category->meta_title) ? $category->meta_title : $category->title;
        $dataSeo['meta_desc'] = !empty($category->meta_desc) ? $category->meta_desc : $category->desc;
        $dataSeo['keyword_seo'] = !empty($category->meta_keyword) ? $category->meta_keyword : $category->title;
        $dataSeo['news_keywords'] = !empty($category->meta_keyword) ? $category->meta_keyword : $category->title;
        $dataSeo['robots'] = !empty($category->robots) ? 'index, follow' : 'noindex, nofollow';

        return view('public.category.index', compact('category', 'posts', 'dataSeo'));

    }
}
