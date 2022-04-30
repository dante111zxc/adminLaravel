<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductCategory;
//use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductCategoryController extends Controller
{

    public function category (Request $request){
        $category = ProductCategory::query()->findOrFail($request->route('id'));
        $productFeature = Product::query()->where([
            'status' => 1,
            'feature' => 1
        ])->orderBy('sort', 'desc')->get();

        $product = $category->products();

        //lọc theo thuộc tính sản phẩm
        if ($request->input('attribute')) {
            $product->whereHas('attribute', function (Builder $query) use ($request) {
                $query->whereIn('attribute_id', $request->input('attribute'));
            });
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


        if (!$request->has('sort_by') || $request->has('sort_by') == 0) {
            $product->orderBy('created_at', 'desc');
        }

        $product->where('stock', 1);


        if ($request->has('product_status')) {
            $product->where('stock', $request->input('product_status'));
        }


        $product = $product->paginate(16);

        $dataFilter = [
            'product_status' => ($request->has('product_status')) ? $request->input('product_status') : 1,
            'attributes' => $request->input('attribute'),
            'price_from' => $request->input('price_from'),
            'price_to' => $request->input('price_to'),
            'sort_by' => $request->input('sort_by'),
        ];

        $attributes = ProductAttributes::query()->whereNull('parent_id')->with('childAttributes')->where('product_attributes.status', 1)->get();
        return view('public.product-category.index', compact('category', 'productFeature', 'product', 'attributes', 'dataFilter'));
    }
}
