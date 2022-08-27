<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CouponTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'discount'
    ];

    protected static $onlyField = [
        'id',
        'title',
        'description',
        'type',
        'discount',
        'action',
        'time',
    ];

    const TYPE = [
        1 => '%',
        2 => 'VND'
    ];

    public static function buildDataTable()
    {
        $couponTemplate = CouponTemplate::query();
        $dataTable = new DataTables();

        $data = $dataTable->eloquent($couponTemplate)
            ->filter( function ($query) {
                if (request()->has('search')) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
                }
            })

            ->editColumn('discount', function ($instance) {
                return $instance->discount .' '. self::TYPE[$instance->type];
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('coupontemplate.edit')) {
                    $html .= '<a href="'.route('coupon-template.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('coupontemplate.delete')) {
                    $html .= '<a data-href="'.route('coupon-template.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
