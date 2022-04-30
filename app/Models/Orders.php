<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'link_facebook',
        'acc_info',
        'user_id',
        'subtotal',
        'total',
        'method_payment',
        'note',
        'email_to',
        'email_content',
        'email_has_send',
        'status',
        'is_vip_member',
        'is_coupon',
        'coupon_id'
    ];

    protected static $onlyField = [
        'id',
        'info',
        'action',
        'is_vip_member',
        'status',
        'time',
    ];

    const STATUS = [
        0 => 'Đang xử lý',
        1 => 'Hoàn thành',
        2 => 'Hủy'
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success',
        2 => 'danger'
    ];

    const METHODS_PAYMENT = [
        1 => 'CK qua tài khoản ngân hàng',
        2 => 'Thanh toán bằng Pcoin',
        3 => 'Thanh toán bằng QR MOMO',
        4 => 'Thanh toán bằng QR VNPAY'
    ];

    public static function  orderDetail ($order_id){
        $model = DB::table('order_detail')
            ->join('products', 'products.id', 'product_id')
            ->where('order_id', $order_id);
        return $model->get();
    }

    public static function getTotalOrderAmountByUserId($userId){
        return Orders::query()->where([
            'user_id' => $userId,
            'status' => 1
        ])->sum('total');
    }

    public static function buildDataTable (){
        $model = Orders::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
            ->filter( function ($query) {
                if ($id = request()->input('filter_id')) {
                    $query->where('id', $id );
                }

                if ($email = request()->input('filter_email')) {
                    $query->where('email', $email);
                }

                if ($phone = request()->input('filter_phone')) {
                    $query->where('phone', $phone);
                }

                if ($isVipMember = request()->input('filter_is_vip_member')) {
                    $query->where('is_vip_member', $isVipMember);
                }
            })
            ->addColumn('info', function ($instance) {

                $html = '<p><b>Mã đơn hàng: </b>#' . $instance->id .'</p>';
                $html .= '<p><b>Khách hàng: </b>' . $instance->name .'</p>';
                $html .= '<p><b>Số điện thoại: </b>' . $instance->phone .'</p>';
                $html .= '<p><b>Địa chỉ: </b>' . $instance->address .'</p>';
                $html .= '<p><b>Email: </b>' . $instance->email .'</p>';
                $html .= '<p><b>Tổng tiền: </b>' .showMoney($instance->subtotal) .'</p>';
                $html .= '<p><b>Thanh toán: </b>' .self::METHODS_PAYMENT[$instance->method_payment] .'</p>';
                return $html;
            })

            ->editColumn('is_vip_member', function ($instance) {
                if ($instance->is_vip_member) {
                    return showRankImg(self::getTotalOrderAmountByUserId($instance->user_id));
                }
                return '<span>Đơn hàng thường</span>';

            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('order.edit')) {
                    $html .= '<a href="'.route('order.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Chi tiết đơn hàng</a>';
                }

                if (Gate::allows('order.delete')) {
                    $html .= '<a data-href="'.route('order.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
    public static function historyOrder (){
        $model = Orders::query()->where([
            'user_id' => Auth::user()->id
        ]);
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
            ->filter( function ($query) {
                if (request('search')['value']) {
                    $query->where('id', request('search')['value'] );
                }
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '<a href="'.route('order_detail', $instance->id).'" class="btn btn-xs btn-primary btn-sm btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Chi tiết</a>';

                return $html;
            })

            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                return $html;
            })
            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
        return $data;
    }

}
