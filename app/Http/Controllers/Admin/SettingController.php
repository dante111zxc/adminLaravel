<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Cassandra\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:setting.view')->only('index');
        $this->middleware('can:setting.edit')->only('update');
    }


    public function index()
    {
        $data = Setting::all();
        $setting = [];
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                $setting[$item->key] = $item->value;
            }
        }
        return view('admin.setting.index', compact('setting'));
    }
    public function update(Request $request)
    {
        $input = $request->all();
        if ($input) {
            $data = [];
            $i = 0;
            foreach ($input as $key => $item) {
                if ($key !== '_token') {
                    $data[$i]['key'] = $key;
                    $data[$i]['value'] = $item;
                    $i++;
                }

            }
        }
        Setting::query()->truncate();
        $insert = Setting::query()->insert($data);
        if ( $insert !== 'false' ) {
            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Lưu cài đặt thành công'
            ]);

        }

        return response()->json([
            'type' => 'error',
            'code' => 500,
            'message' => 'Có lỗi xảy ra'
        ]);
    }

}
