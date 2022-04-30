<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MethodPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MethodPaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:methodpayments.view')->only('index');
        $this->middleware('can:methodpayments.create')->only(['create', 'store']);
        $this->middleware('can:methodpayments.edit')->only(['edit', 'update']);
        $this->middleware('can:methodpayments.delete')->only('destroy');
    }


    public function index()
    {
        return  view('admin.method-payments.index');
    }


    public function dataTable (){
        return MethodPayments::buildDataTable();
    }

    public function create()
    {
        $listBanksData = MethodPayments::getListBanks();
        $listBanks = [];
        if (!empty($listBanksData['data'])) foreach ($listBanksData['data'] as $key => $item) {
            if ($item['methodCode'] == 'ATM_ON' || $item['bankId'] == 89) {
                $listBanks[$key] = $item;
            }
        }
        return view ('admin.method-payments.create', compact('listBanks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'account_number' => 'required',
            'account_name' => 'required|string',
            'bank_name' => 'required|string',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'account_number.required' => 'Số tài khoản không được bỏ trống',
            'account_number.int' => 'Số tài khoản phải là dạng số nguyên',
            'account_number.unique' => 'Số tài khoản đã tồn tại',
            'account_name.required' => 'Tên tài khoản không được bỏ trống',
            'bank_name.required' => 'Tên ngân hàng không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new MethodPayments();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('methodpayments.edit', $model->id )->with('success', 'Tạo phương thức thanh toán thành công');
    }

    public function edit($id)
    {
        $method = MethodPayments::query()->findOrFail($id);
        $listBanksData = MethodPayments::getListBanks();
        $listBanks = [];

        if (!empty($listBanksData['data'])) foreach ($listBanksData['data'] as $key => $item) {
            if ($item['methodCode'] == 'ATM_ON' || $item['bankId'] == 89) {
                $listBanks[$key] = $item;
            }
        }
        return view('admin.method-payments.edit', compact('method', 'listBanks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'account_number' => "required",
            'account_name' => 'required|string',
            'bank_name' => 'required|string',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'account_number.required' => 'Số tài khoản không được bỏ trống',
            'account_number.int' => 'Số tài khoản phải là dạng số nguyên',
            'account_number.unique' => 'Số tài khoản đã tồn tại',
            'account_name.required' => 'Tên tài khoản không được bỏ trống',
            'bank_name.required' => 'Tên ngân hàng không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = MethodPayments::query()->find($id);
        $save = $model->fill($request->all())->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('methodpayments.edit', $model->id )->with('success', 'Cập nhật phương thức thanh toán thành công');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $post = MethodPayments::query()->find($id);
                if ($post->delete()) {
                    return response()->json([
                        'type' => 'success',
                        'code' => 200,
                        'message' => 'Xóa bản ghi thành công'
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

    }

}
