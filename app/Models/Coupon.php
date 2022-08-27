<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'title',
        'code',
        'coupon_template_id',
        'number_of_uses',
        'status'
    ];

    protected static $onlyField = [
        'id',
        'title',
        'code',
        'number_of_uses',
        'action',
        'time',
    ];


    public static function buildDataTable()
    {
        $coupon = Coupon::query();
        $dataTable = new DataTables();

        $data = $dataTable->eloquent($coupon)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('coupon.edit')) {
                    $html .= '<a href="'.route('coupon.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('coupon.delete')) {
                    $html .= '<a data-href="'.route('coupon.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
