<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'parent_id',
        'status',
        'robots',
        'thumbnail',
        'type'
    ];

    protected static $onlyField = [
        'id',
        'thumbnail',
        'title',
        'parent_category',
        'status',
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
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('categories');
    }

    public function posts (){
        return $this->belongsToMany(Post::class, 'post_category');
    }

    public static function postRelated ($categoryId, $postId){
        return DB::table('posts')
            ->join('post_category', 'posts.id', '=', 'post_category.post_id')
            ->whereIn('post_category.category_id', $categoryId)
            ->whereNotIn('post_category.post_id', [$postId])
            ->groupBy('posts.id')
            ->orderBy('posts.id', 'desc')->limit(2)->get();
    }

    public function parent (){
        return $this->hasOne(Category::class,'parent_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }
    public static function buildDataTable (){
        $taxonomy = Category::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($taxonomy)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }

            })
            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })

            ->addColumn('parent_category', function ($instance) {
                if (!empty($instance->parent_id)) {
                    $parent_category = Category::query()->find($instance->parent_id);
                    return '<a class="btn btn-xs btn-info" href="'.route('category.edit', $parent_category->id).'">'.$parent_category->title.'</a>';
                }
                else {
                    return '';
                }
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('category.edit')) {
                    $html .= '<a href="'.route('category.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('category.delete')) {
                    $html .= '<a data-href="'.route('category.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
