<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'title',
        'desc',
        'slug',
        'short_desc',
        'price',
        'price_sale',
        'product_related',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'content',
        'robots',
        'status',
        'feature',
        'sort',
        'stock',
        'thumbnail',
        'gallery',
        'post_author'
    ];

    protected static $onlyField = [
        'id',
        'title',
        'thumbnail',
        'info',
        'action',
        'status',
        'feature',
        'sort',
        'time',
    ];

    const STATUS = [
        0 => 'Ẩn',
        1 => 'Hiện'
    ];

    const STOCK = [
        0 => 'Hết hàng',
        1 => 'Còn hàng'
    ];


    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success'
    ];

    public function setGalleryAttribute ($value) {
        $this->attributes['gallery'] = json_encode($value);
    }
    public function setProductRelatedAttribute ($value){
        $this->attributes['product_related'] = json_encode($value);
    }

    public function category(){
        return $this->belongsToMany(ProductCategory::class, 'product_category', 'product_id', 'category_id');
    }

    public function tag (){
        return $this->belongsToMany(ProductTag::class, 'product_tag', 'product_id', 'tag_id');
    }

    public function attribute (){
        return $this->belongsToMany(ProductAttributes::class, 'product_attribute', 'product_id', 'attribute_id');
    }


    public static function buildDataTable (){
        $model = Product::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }
            })
            ->editColumn('title', function ($instance) {
                return '<a class="btn-link" href="'.route('product', ['id'=> $instance->id, 'slug' => $instance->slug]).'">'.$instance->title.'</a>';
            })
            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })
            ->addColumn('info', function ($instance) {

                //danh mục sản phẩm
                $html = '<p><b>Danh mục sản phẩm: </b>';
                if (!empty($instance->category)) {
                    foreach ($instance->category as $key => $item) {
                        if (Gate::allows('product-category.edit')) {
                            $html .= '<a class="btn btn-xs btn-info mr-2 mb-2" href="'.route('product-category.edit', $item->id).'">'.$item->title.'</a>';
                        }
                    }
                }
                $html .= '</p>';

                //tag sản phẩm
                $html .= '<p><b>Tag: </b>';
                if (!empty($instance->tag)) {
                    foreach ($instance->tag as $key => $item) {
                        if (Gate::allows('product-tag.edit')) {
                            $html .= '<a class="btn btn-xs btn-success mr-2" href="'.route('product-tag.edit', $item->id).'">'.$item->title.'</a>';
                        }
                    }
                }
                $html .= '</p>';


                //thuộc tính sản phẩm
                $html .= '<p><b>Thuộc tính sản phẩm: </b>';
                if (!empty($instance->attribute)) {
                    foreach ($instance->attribute as $key => $item) {
                        if (Gate::allows('product-attributes.edit')) {
                            $html .= '<a class="btn btn-xs btn-primary mb-2 mr-2" href="'.route('product-attributes.edit', $item->id).'">'.$item->title.'</a>';
                        }
                    }
                }

                $html .= '</p>';

                //Giá sản phẩm
                $html .= '<p><b>Giá gốc: '.showMoney($instance->price).'</b></p>';

                //Giá sale
                $html .= '<p><b class="text-danger">Giá sale: '.showMoney($instance->price_sale).'</b></p>';


                return $html;
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })
            ->editColumn('feature', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->feature].'">'.self::STATUS[$instance->feature].'</span>';
            })
            ->editColumn('sort', function ($instance) {
                return '<span>'.$instance->sort.'</span>';
            })
            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('product.edit')) {
                    $html .= '<a href="'.route('product.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('product.delete')) {
                    $html .= '<a data-href="'.route('product.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
                }

                return $html;
            })

            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                $html .= '<div><b>Ngày cập nhật: </b>'.date('d/m/Y H:i', strtotime($instance->updated_at)).'</div>';
                return $html;
            })
            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
        return $data;
    }
}
