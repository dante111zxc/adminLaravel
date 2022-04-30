<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\DatabaseObject;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class ProductAttributes extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'parent_id',
        'type',
        'status',
        'thumbnail'
    ];
    protected static $onlyField = [
        'id',
        'thumbnail',
        'title',
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

    public function attributes()
    {
        return $this->hasMany(ProductAttributes::class, 'parent_id', 'id');
    }

    public function childAttributes()
    {
        return $this->hasMany(ProductAttributes::class, 'parent_id', 'id')->with('attributes');
    }


    /**
     * Danh sách các loại thuộc tính của sản phẩm
     *
     * @return $data
     */
    public static function buildDataTable (){
        $model = ProductAttributes::query()->where([
            'parent_id' => null
        ]);
        $dataTable = new DataTables();
        return $dataTable->eloquent($model)->filter( function ($query) {
            if (request()->has('search')) {
                $query->where('title', 'like', "%" . request('search')['value'] . "%")
                ;
            }
        })

            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })
            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('product-attributes.edit')) {
                    $html .= '<a href="'.route('product-attributes.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                    $html .='<a href="'.route('attributes_index', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Danh sách thuộc tính</a>';
                }

                if (Gate::allows('product-attributes.delete')) {
                    $html .= '<a data-href="'.route('product-attributes.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
                }




                return $html;
            })
            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                $html .= '<div><b>Ngày cập nhật: </b>'.date('d/m/Y H:i', strtotime($instance->updated_at)).'</div>';
                return $html;
            })
            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);

    }

    /**
     * Danh sách các thuộc tính của sản phẩm
     * @param  $type
     * @return DatabaseObject
     */
    public static function buildDataTableAttributes ($parent_id, $type){
        $model = ProductAttributes::query()->where([
            'type' => $type,
            'parent_id' => $parent_id
        ]);
        $dataTable = new DataTables();
        return $dataTable->eloquent($model)->filter( function ($query) {
            if (request()->has('search')) {
                $query->where('title', 'like', "%" . request('search')['value'] . "%")
                ;
            }
        })
            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })
            ->addColumn( 'action', function ($instance) use ($parent_id)  {
                $html = '';
                if (Gate::allows('product-attributes.edit')) {
                    $html .= '<a href="'.route('attributes_edit', ['id' => $parent_id, 'attribute_id' => $instance->id] ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                    if ($instance->parent_id === null) {
                        $html .='<a href="'.route('attributes_index', $parent_id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Danh sách thuộc tính</a>';
                    }
                }

                if (Gate::allows('product-attributes.delete')) {
                    $html .= '<a data-href="'.route('attributes_destroy', ['id' => $parent_id, 'attribute_id' => $instance->id] ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
                }




                return $html;
            })
            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                $html .= '<div><b>Ngày cập nhật: </b>'.date('d/m/Y H:i', strtotime($instance->updated_at)).'</div>';
                return $html;
            })
            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
    }
}
