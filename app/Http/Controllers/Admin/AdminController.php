<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.view')->only('index');
        $this->middleware('can:admin.create')->only(['create', 'store']);
        $this->middleware('can:admin.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.delete')->only('destroy');
    }


    public function index()
    {
        return view('admin.admin.index');

    }
    public function dataTable() {
        return Admin::buildDataTable();
    }
    public function create() {
        $roles = Role::all();
        return view('admin.admin.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => "required|min:6|email|unique:admins,email",
            'name' => 'required|min:3',
            'password' => 'min:6|required_with:password_confirm',
            'password_confirm' => 'min:6|same:password',
            'desc' => 'string|nullable',
            'thumbnail' => 'string|nullable',
            'role_id' => 'required'
        ],[
            'email.required' => 'Email không được bỏ trống',
            'email.min' => 'Email phải có tối thiểu 6 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'name.required' => 'Họ tên không được bỏ trống',
            'name.min' => 'Họ tên phải có tối thiểu 6 ký tự',
            'password.min' => 'Mật khẩu phải có tối thiểu 6 ký tự',
            'password.required_with' => 'Mật khẩu xác nhận không được bỏ trống',
            'password_confirm.min' => 'Mật khẩu phải có tổi thiểu 6 ký tự',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp',
            'role_id.required' => 'Quyền quản trị không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = new Admin();
        $admin->fill($request->all());
        $admin->password = Hash::make($request->input('password'));
        $save = $admin->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('admin.edit', $admin->id)->with('success', 'Tạo user thành công');
    }
    public function edit($id)
    {

        $roles = Role::all();
        $admin = Admin::query()->find($id);
        return view('admin.admin.edit', [
            'user' => $admin,
            'roles' => $roles
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'email' => "required|min:6|email|unique:admins,email,". $id,
            'name' => 'required|min:3',
            'password' => 'required_with:password_confirm|nullable',
            'password_confirm' => 'same:password|nullable',
            'desc' => 'string|nullable',
            'thumbnail' => 'string|nullable',
            'role_id' => 'required'
        ],[
            'email.required' => 'Email không được bỏ trống',
            'email.min' => 'Email phải có tối thiểu 6 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'name.required' => 'Họ tên không được bỏ trống',
            'name.min' => 'Họ tên phải có tối thiểu 6 ký tự',
            'password.required_with' => 'Mật khẩu xác nhận không khớp',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp',
            'role_id.required' => 'Quyền quản trị không được bỏ trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = Admin::find($id);
        $admin->fill($request->all());
        if (!empty($request->input('password'))) {
            $admin->password = Hash::make($request->input('password'));
        }
        $save = $admin->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('admin.edit', $admin->id)->with('success', 'Cập nhật user thành công');
    }
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $admin = Admin::find($id);
            $delete = $admin->delete();
            if (!$delete) {
                return response()->json([
                    'type' => 'error',
                    'code' => 500,
                    'message' => 'Có lỗi xảy ra'
                ]);
            }

            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Xóa bản ghi thành công'
            ]);
        }
        return response()->json([
            'type' => 'error',
            'code' => 500,
            'message' => 'Có lỗi xảy ra'
        ]);
    }
}
