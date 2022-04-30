<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class TransactionPcoin extends Model
{
    use HasFactory;
    protected $table = 'transaction_pcoin';
    protected $fillable = [
        'user_id',
        'request_id',
        'status',
        'type',
        'note',
        'thumbnail'
    ];

    protected static $onlyField = [
        'id',
        'request_id',
        'transaction_code',
        'user',
        'type',
        'status',
        'action',
        'time',
    ];

    const TYPE = [
        1 => 'Nạp Pcoin bằng thẻ điện thoại',
        2 => 'CK qua ngân hàng',
        3 => 'Internet Banking',
    ];

    const STATUS = [
        0 => 'Đang xử lý',
        1 => 'Hoàn thành',
        2 => 'Lỗi'
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success',
        2 => 'danger'
    ];

    public static function buildDataTable (){
        $transaction = TransactionPcoin::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($transaction)
            ->filter(function ($query) {
                if ( !empty( $filter_email = request()->input('filter_email') ) ) {
                    $query->whereHas('user', function ($q) use ($filter_email) {
                        $q->where('email', 'like', "%$filter_email%");
                    });
                }


                if ( !empty(  $filter_request_id = request()->input('filter_request_id') ) ) {
                    $query->where([
                        'request_id' => $filter_request_id
                    ]);
                }

                if (!empty( $filter_transaction_code = request()->input('filter_transaction_code'))) {
                    $query->whereHas('banking', function ($q) use ($filter_transaction_code) {
                        $q->where([
                            'transaction_code' => $filter_transaction_code
                        ]);
                    });
                }

                if ( !empty( $filter_method_payment = request()->input('filter_method_payment') ) ) {
                    $query->where([
                       'type' => $filter_method_payment
                    ]);
                }
            })


            ->addColumn('transaction_code', function ($instance) {
                $transaction_code = Banking::query()->where([
                    'request_id' => $instance->request_id
                ])->first();
                if (!empty($transaction_code)) {
                    return $transaction_code->transaction_code;
                }
                return '';
            })
            ->addColumn('user', function ($instance) {
                $user = User::query()->find($instance->user_id);
                return $user->email;
            })

            ->editColumn('type', function ($instance){
                return self::TYPE[$instance->type];
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('transactionpcoin.edit')) {
                    $html .= '<a href="'.route('transaction-pcoin.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Chi tiết</a>';
                }

                if (Gate::allows('transactionpcoin.delete')) {
                    $html .= '<a data-href="'.route('transaction-pcoin.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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

    public static function transactionHistoryPayCoinByCard(){
        $transaction = TransactionPcoin::query()->where([
            'type' => 1,
            'user_id' => Auth::user()->id
        ]);
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($transaction)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {
                    $query->where('request_id', request('search')['value']);
                }
            })


            ->editColumn('type', function ($instance){
                return self::TYPE[$instance->type];
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '<a href="#" class="btn btn-xs btn-primary btn-sm btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Chi tiết</a>';
                return $html;
            })

            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                return $html;
            })

            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
        return $data;
    }
    public static function transactionHistoryPayCoinByBank(){
        $transaction = TransactionPcoin::query()->where([
            'type' => 2,
            'user_id' => Auth::user()->id
        ]);
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($transaction)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {
                    $query->where('request_id', request('search')['value']);
                }
            })


            ->editColumn('type', function ($instance){
                return self::TYPE[$instance->type];
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '<a href="#" class="btn btn-xs btn-primary btn-sm btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Chi tiết</a>';
                return $html;
            })

            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                return $html;
            })

            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
        return $data;
    }
    public function user (){
        return $this->belongsTo(User::class);
    }
    public function banking (){
        return $this->hasOne(Banking::class,'request_id', 'request_id');
    }
}
