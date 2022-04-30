<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user.view')->only('index');
        $this->middleware('can:user.create')->only(['create', 'store']);
        $this->middleware('can:user.edit')->only(['edit', 'update']);
        $this->middleware('can:user.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function dataTable() {
        return User::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => "required|min:6|email|unique:users,email",
            'name' => 'required|min:3',
            'password' => 'min:6|required_with:password_confirm',
            'password_confirm' => 'min:6|same:password',
            'thumbnail' => 'string|nullable',
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->input('password'));
        $save = $user->save();


        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('user.edit', $user->id)->with('success', 'Tạo user thành công');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::query()->find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'email' => "required|min:6|email|unique:users,email,". $id,
            'name' => 'required|min:3',
            'thumbnail' => 'string|nullable',
        ],[
            'email.required' => 'Email không được bỏ trống',
            'email.min' => 'Email phải có tối thiểu 6 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'name.required' => 'Họ tên không được bỏ trống',
            'name.min' => 'Họ tên phải có tối thiểu 6 ký tự',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::query()->find($id);
        $user->fill($request->all());

        $save = $user->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('user.edit', $user->id)->with('success', 'Cập nhật user thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $admin = User::query()->find($id);
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

    public function changePassword ($id){
        $user = User::query()->find($id);
        return view('admin.user.change_password', compact('user'));
    }

    public function changePasswordStore (Request $request, $id){
        $validator = Validator::make($request->all() ,[
            'password' => 'required|required_with:password_confirm|min:6',
            'password_confirm' => 'required|same:password|min:6',
        ],[
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password_confirm.required' => 'Mật khẩu xác nhận không được bỏ trống',
            'password.required_with' => 'Mật khẩu xác nhận không khớp',
            'password.min' => 'Mật khẩu phải có tối thiểu 6 ký tự',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp',
            'password_confirm.min' => 'Mật khẩu xác nhận phải có tối thiểu 6 ký tự'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::query()->find($id);
        $user->password = Hash::make($request->input('password'));
        $save = $user->save();
        if (!$save) return redirect()->back()->withErrors(['messages' => 'Có lỗi xảy ra'])->withInput();
        return redirect()->route('user.change_password', $user->id)->with('success', 'Cập nhật mật khẩu thành công');
    }
}
