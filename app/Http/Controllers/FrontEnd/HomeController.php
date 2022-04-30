<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Slides;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home() {

        //bài viết mới nhất
        $lastedPost = Post::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->take(3)->get();

        //sản phẩm nổi bật
        $productFeature = Product::query()->where([
            'status' => 1,
            'feature' => 1
        ])->orderBy('sort', 'desc')->take(10)->get();


        //danh mục nổi bật
        $productCategoryFeature = ProductCategory::query()->where([
            'status' => 1,
            'feature' => 1
        ])->orderBy('sort', 'desc')->get();

        //slide
        $slide = Slides::query()->where([
            'status' => 1,
            'type' => 'slide'
        ])->orderBy('order', 'desc')->get();

        //banner
        $banner = Slides::query()->where([
            'status' => 1,
            'type' => 'image'
        ])->orderBy('order', 'desc')->get();



        //data seo
        $setting = Setting::all()->toArray();
        $dataSeo = [];
        foreach ($setting as $item) {
            $dataSeo[$item['key']] = $item['value'];
        }
        $dataSeo['robots'] = 'index, follow';


        return view('public.home', compact('dataSeo', 'lastedPost', 'slide', 'banner', 'productCategoryFeature', 'productFeature'));
    }
}
