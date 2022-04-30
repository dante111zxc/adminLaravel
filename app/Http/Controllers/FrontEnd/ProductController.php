<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Reviews;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product (Request $request) {
        $product = Product::query()->findOrFail($request->route('id'));
        $category = $product->category;
        $setting = Setting::query()->where([
            'key' => 'service'
        ])->first();


        //sale off
        $saleOff = 0;
        if (!empty($product->price_sale) && $product->price_sale < $product->price) {
            $saleOff = round(100 - (($product->price_sale * 100) / $product->price));
        }

        $productBundleId = json_decode($product->product_related);
        if (!empty($productBundleId)) $productBundle = Product::query()->whereIn('id', $productBundleId)->get();

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
                    'url' => route('product_category', ['id' => $item->id, 'slug' => $item->slug])
                ]);
            }
        }

        $reviews = Reviews::query()->where([
           'type' => 'product',
           'post_id' => $product->id,
           'status' => 1
        ])->paginate(10);

        //dem so luot vote
        $countVote = Reviews::query()->where([
            'type' => 'product',
            'post_id' => $product->id,
            'status' => 1
        ])->count();




        if ($countVote) {
            //tinh diem trung binh
            $average = Reviews::query()->where([
                'type' => 'product',
                'post_id' => $product->id,
                'status' => 1
            ])->sum('vote');
            $average = round($average / $countVote);
        }


        //Seo meta
        $dataSeo['site_name'] = !empty($product->meta_title) ? $product->meta_title : $product->title;
        $dataSeo['meta_desc'] = !empty($product->meta_desc) ? $product->meta_desc : $product->title;
        $dataSeo['keyword_seo'] = !empty($product->meta_keyword) ? $product->meta_keyword : $product->title;
        $dataSeo['news_keywords'] = !empty($product->meta_keyword) ? $product->meta_keyword : $product->title;
        $dataSeo['logo'] = $product->thumbnail;
        $dataSeo['robots'] = !empty($product->robots) ? 'index, follow' : 'noindex, nofollow';
        return view('public.product.index', [
            'product' => $product,
            'breadcrumb' => $breadcrumb,
            'saleOff' => !empty($saleOff) ? $saleOff : null,
            'productBundle' => !empty($productBundle) ? $productBundle : null,
            'setting' => !empty($setting) ? $setting : null,
            'dataSeo' => $dataSeo,
            'reviews' => $reviews,
            'average' => !empty($average) ? $average : null,
            'countVote' => $countVote
        ]);
    }
    public function search (Request $request){
        $keyword = $request->input('search_keyword');
        $product = Product::query()->where('title', 'like', "%$keyword%")->orderBy('sort', 'desc');

        if ($request->has('product_status')) {
            $product->where('stock', $request->input('product_status'));
        }

        //lọc theo khoảng gía
        if ($request->input('price_from')) {
            $product->where('price', '>=', $request->input('price_from'));

            if ($request->input('price_to')) {
                $product->where('price', '<=', $request->input('price_to'));
            }
        }

        //gia thap den cao
        if ($request->input('sort_by') == 1) {
            $product->orderBy('price', 'asc');
        }

        //gia cao den thap
        if ($request->input('sort_by') == 2) {
            $product->orderBy('price', 'desc');
        }


        //ten A-z
        if ($request->input('sort_by') == 3){
            $product->orderBy('title', 'asc');
        }

        //ten Z-A
        if ($request->input('sort_by') == 4) {
            $product->orderBy('title', 'desc');
        }

        //san pham giam gia
        if ($request->input('sort_by') == 5) {
            $product->where('price_sale', '!=', 0);
            $product->orderBy('price_sale', 'asc');
        }



        $product = $product->paginate(16);
        $dataFilter = [
            'product_status' => ($request->has('product_status')) ? $request->input('product_status') : 1,
            'attributes' => $request->input('attribute'),
            'price_from' => $request->input('price_from'),
            'price_to' => $request->input('price_to'),
            'sort_by' => $request->input('sort_by'),
        ];
        return view('public.product.search', compact('keyword', 'dataFilter', 'product'));
    }
}
