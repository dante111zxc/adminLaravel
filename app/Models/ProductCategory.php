<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'parent_id',
        'robots',
        'status',
        'feature',
        'sort',
        'thumbnail'
    ];


    protected static $onlyField = [
        'id',
        'thumbnail',
        'title',
        'parent_category',
        'status',
        'feature',
        'sort',
        'action',
        'time',
    ];

    const STATUS = [
        0 => 'Ẩn',
        1 => 'Hiện'
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success'
    ];

    public function categories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }
    public function childCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id')->with('categories');
    }

    public function products (){
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id')->distinct();
    }




    public static function buildDataTable (){
        $model = ProductCategory::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)->filter( function ($query) {
            if (request()->has('search')) {
                $query->where('title', 'like', "%" . request('search')['value'] . "%")
                ;
            }
        })

        ->editColumn('thumbnail', function ($instance) {
            return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
        })
        ->addColumn('parent_category', function ($instance) {
            if (!empty($instance->parent_id)) {
                $parent_category = ProductCategory::query()->find($instance->parent_id);
                return '<a class="btn btn-xs btn-info" href="'.route('category.edit', $parent_category->id).'">'.$parent_category->title.'</a>';
            }
            else {
                return '';
            }
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

            if (Gate::allows('product-category.edit')) {
                $html .= '<a href="'.route('product-category.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
            }

            if (Gate::allows('product-category.delete')) {
                $html .= '<a data-href="'.route('product-category.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
