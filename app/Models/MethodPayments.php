<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class MethodPayments extends Model
{
    use HasFactory;
    protected $table = 'method_payments';
    protected $fillable = [
        'title',
        'account_number',
        'account_name',
        'bank_name',
        'bank_code',
        'type',
        'status',
        'thumbnail',
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





    public static function buildDataTable (){
        $model = MethodPayments::query();
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
                $html = '<p><b>Số tài khoản: </b>';

                if (!empty($instance->account_number)) {
                    $html .= '<span>'.$instance->account_number.'</span>';
                }

                $html .= '</p>';

                $html .= '<p><b>Chủ tài khoản: </b>';

                if (!empty($instance->account_name)) {
                    $html .= '<span>'.$instance->account_name.'</span>';
                }

                $html .= '</p>';

                $html .= '<p><b>Tên ngân hàng: </b>';
                if (!empty($instance->bank_name)) {
                    $html .= '<span>'.$instance->bank_name.'</span>';
                }
                $html .= '</p>';

                return $html;
            })

            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('methodpayments.edit')) {
                    $html .= '<a href="'.route('methodpayments.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('methodpayments.delete')) {
                    $html .= '<a data-href="'.route('methodpayments.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
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
    public static function getListBanks (){
        $url = env('ALEPAY_URL') . 'get-list-banks';
        $data['tokenKey'] = env('ALEPAY_API_KEY');
        $data['signature'] = self::makeSignature($data, env('ALEPAY_CHECKSUM_KEY'));
        $response = Http::acceptJson()->withoutVerifying()->post($url, $data)->json();
        return $response;
    }

    private static function makeSignature ($data, $hash_key) {
        $hash_data = '';
        ksort($data);
        $is_first_key = true;
        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            if (!$is_first_key) {
                $hash_data .= '&' . $key . '=' . $value;
            } else {
                $hash_data .= $key . '=' . $value;
                $is_first_key = false;
            }
        }

        $signature = hash_hmac('sha256', $hash_data, $hash_key);
        return $signature;
    }
}
