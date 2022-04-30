<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Self_;
use Yajra\DataTables\DataTables;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desc',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'content',
        'robots',
        'status',
        'thumbnail',
        'post_author'
    ];

    protected static $onlyField = [
        'id',
        'title',
        'thumbnail',
        'info',
        'action',
        'status',
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

    public function category(){
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'category_id');
    }

    public function tag (){
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }


    public static function buildDataTable (){
        $model = Post::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }
            })
            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })
            ->addColumn('info', function ($instance) {
                $html = '<p><b>Danh mục: </b>';

                if (!empty($instance->category)) {
                    foreach ($instance->category as $key => $item) {
                        if (Gate::allows('category.edit')) {
                            $html .= '<a class="btn btn-xs btn-info mr-2 mb-2" href="'.route('category.edit', $item->id).'">'.$item->title.'</a>';
                        }
                    }
                }

                $html .= '</p>';
                $html .= '<p><b>Tag: </b>';

                if (!empty($instance->tag)) {
                    foreach ($instance->tag as $key => $item) {
                        if (Gate::allows('tag.edit')) {
                            $html .= '<a class="btn btn-xs btn-success mr-2" href="'.route('tag.edit', $item->id).'">'.$item->title.'</a>';
                        }
                    }
                }

                $html .= '</p>';
                return $html;
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('post.edit')) {
                    $html .= '<a href="'.route('post.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('post.delete')) {
                    $html .= '<a data-href="'.route('post.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
