<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
/**
 * Admin
 * @mixin Model
 *
 * */

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $guarded = [

    ];
    public static $action = [
        'view',
        'create',
        'edit',
        'delete'
    ];
    protected $fillable = [
        'name',
        'email',
        'desc',
        'thumbnail',
        'status',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected static $onlyField = [
        'id',
        'thumbnail',
        'info',
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

    public static function hasPermission ($role_id, $code){
        $permissions = Permission::query()->where('role_id', $role_id)->get();
        if (!empty($permissions)) {
            $permissionArr = [];
            foreach ($permissions as $key => $item) {
                $permissionArr[] = $item->code;
            }
            return in_array($code, $permissionArr, true);
        }

        return false;
    }

    public static function buildDataTable (){
        $admin = Admin::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($admin)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }
            })

            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })

            ->addColumn('info', function ($instance) {
                $role = Role::query()->find($instance->role_id);
                $html = '<div><b>Họ và tên: </b>'.$instance->name.'</div>';
                $html .= '<div><b>Email: </b>'.$instance->email.'</div>';
                $html .= '<div><b>Nhóm quyền: </b>'.$role->title.'</div>';
                return $html;
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('admin.edit')) {
                    $html .= '<a href="'.route('admin.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('admin.delete')) {
                    $html .= '<a data-href="'.route('admin.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
