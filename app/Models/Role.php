<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Role extends Model
{
    use HasFactory;

    public static $action = [
        'view',
        'create',
        'edit',
        'delete'
    ];


    protected $table = 'roles';
    protected $fillable = [
        'title',
        'desc',
        'status',
    ];



    protected static $onlyField = [
        'id',
        'title',
        'status',
        'action',
        'time'
    ];
    const STATUS = [
        0 => 'Ẩn',
        1 => 'Hiện'
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success'
    ];

    public static function buildDataTable(){
        $model = Role::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where('title', 'like', "%" . request('search')['value'] . "%");
            }
        })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';
                if (Gate::allows('role.edit')) {
                    $html .= '<a href="'.route('role.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('role.delete')) {
                    $html .= '<a data-href="'.route('role.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
    public function permission (){
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }

}
