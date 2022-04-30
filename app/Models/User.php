<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number',
        'phone',
        'address',
        'gender',
        'thumbnail',
        'pcoin',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $onlyField = [
        'id',
        'thumbnail',
        'info',
        'email_verified_at',
        'action',
        'time',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public static function buildDataTable (){
        $admin = User::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($admin)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $query->where('email', 'like', "%" . request('search')['value'] . "%");
                }
            })

            ->editColumn('thumbnail', function ($instance) {
                return '<img class="thumbnail" src="'.getThumbnail($instance->thumbnail).'">';
            })

            ->addColumn('info', function ($instance) {
                $html = '<div><b>Họ và tên: </b>'.$instance->name.'</div>';
                $html .= '<div><b>Email: </b>'.$instance->email.'</div>';
                $html .= '<div><b>Số ĐT: </b>'.$instance->phone.'</div>';
                $html .= '<div><b>Địa chỉ: </b>'.$instance->address.'</div>';
                return $html;
            })

            ->editColumn('email_verified_at', function ($instance) {
                if ($instance->email_verified_at !== null) {
                    return '<span class="label label-success">Hoạt động</span>';

                } else {
                    return '<span class="label label-danger">Tài khoản bị khóa</span>';
                }
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('user.edit')) {
                    $html .= '<a href="'.route('user.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                    $html .= '<a href="'.route('user.change_password', $instance->id).'" class="btn btn-xs btn-info" style="margin-right: 5px"><i class="fa fa-fw fa-key"></i> Đổi mật khẩu</a>';
                }

                if (Gate::allows('user.delete')) {
                    $html .= '<a data-href="'.route('user.destroy', $instance->id ).'" style="margin-top: 5px" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
