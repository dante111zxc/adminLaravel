<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;
    public function dashboard (){
        return view('admin.dashboard');
    }

    public function showLoginForm (){
        return view('admin.auth.login_form');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }


    public function login (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:3',
            'password' => 'required|min:6'
        ],[
            'email.required' => 'Vui lòng nhập email',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'email.email' => 'Sai định dạng email',
            'password.min' => 'Mật khẩu tối thiểu phải có 6 ký tự',
            'email.min' => 'Email phải có tối thiểu 3 ký tự'
        ]);

        if ( method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request) ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($validator->fails()) {
            $this->incrementLoginAttempts($request);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $remember = !empty($request->input('remember_token')) ? true : false;
        if (Auth::guard('admin')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 1
        ], $remember)) {
            $this->clearLoginAttempts($request);
            return redirect()->route('admin.dashboard');
        }

        $this->incrementLoginAttempts($request);
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['message' => 'Sai tên đăng nhập hoặc mật khẩu. Vui lòng kiểm tra lại!']);
    }

}
