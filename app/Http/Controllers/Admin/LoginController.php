<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{    public function logout(){
        Auth::logout();
        \request()->session()->invalidate();
        return redirect()->route('admin.loginForm');
    }
    public function loginForm(){
        return view('admin.layout.account.login');
    }
    //dang nhap
    public function login(Request $request) {
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required'=>'Email không được bỏ trống',
            'password.required'=>'Password không được bỏ trống'
        ]);
    
        if (Auth::attempt($login)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role==2 || $user->role==1) { 
                $request->session()->put('user_name', $user->name);
                return redirect()->intended('admin');
            } else {
                Auth::logout(); 
                return back()->withErrors([
                    'err' => 'Bạn không có quyền truy cập vào trang admin',
                ])->onlyInput('err');
            }
        }
    
        return back()->withErrors([
            'err' => 'Thông tin đăng nhập không tồn tại',
        ])->onlyInput('err');
    }
}
