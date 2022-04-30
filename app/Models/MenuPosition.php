<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MenuPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'position',
        'status',
    ];

    protected static $onlyField = [
        'id',
        'title',
        'position',
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



    public static function buildDataTable (){
        $taxonomy = MenuPosition::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($taxonomy)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }

            })
            ->editColumn('status', function ($instance){
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })
            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('menuposition.edit')) {
                    $html .= '<a href="'.route('menuposition.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                    $html .= '<a href="'.route('menu.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Thêm liên kết</a>';
                }

                if (Gate::allows('menuposition.delete')) {
                    $html .= '<a data-href="'.route('menuposition.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';

                }
                return $html;
            })
            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                $html .= '<div><b>Ngày cập nhật: </b>'.date('d/m/Y H:i', strtotime($instance->updated_at)).'</div>';
                return $html;
            })

           ->rawColumns(self::$onlyField)->make(true);
        return $data;
    }

}
