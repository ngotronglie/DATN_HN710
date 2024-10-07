<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserRequest;


class AccountController extends Controller
{
    public function loginForm() {
        // hiển thị form login
        return view('client.pages.login');
    }
    public function login(request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email'=>'Email không được bỏ trống',
            'password'=>'Mật khẩu không được bỏ trống'
        ]);
       
        if (Auth::attempt($credentials)) {
            if (Auth::user()->email_verified_at === null) {
                Auth::logout();
                return back()->withErrors([
                    'error' => 'Email chưa được xác minh,vui lòng kiểm tra hộp thư',
                ])->onlyInput('email');
            }
            if(Auth::user()->is_active==0){
                Auth::logout();
                return back()->withErrors([
                    'error' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên.',
                ]);
            }
                $request->session()->regenerate();
            return redirect()->route('home')->with('success','Đăng nhập thành công');
        }
    
        return back()->withErrors([
            'error' => 'Thông tin không chính xác,vui lòng kiểm tra lại',
        ])->onlyInput('email');
    }
    public function logout() {
        // xử lý logout
        Auth::logout();
        \request()->session()->invalidate();
        return redirect()->route('home')->with('success','Đăng xuất thành công');
    }
    public function verify($token)
    {
        $user = User::query()
            ->where('email', base64_decode($token))
            ->whereNull('email_verified_at')
            ->first();
    
        if (!$user || $user->email_verification_expires_at < Carbon::now()) {
            if ($user) {
                $user->update([
                    'email_verification_expires_at' => Carbon::now()->addMinutes(30)
                ]);
                    $token = base64_encode($user->email);
                Mail::to($user->email)->send(new VerifyEmail($user->name, $token));
    
                return redirect('login')->withErrors([
                    'error' => 'Liên kết xác thực đã hết hạn. Đã gửi liên kết mới, vui lòng kiểm tra email.',
                ]);
            }
    
            return redirect('login')->withErrors([
                'error' => 'Liên kết xác thực không hợp lệ hoặc đã hết hạn.',
            ]);
        }
            $user->update(['email_verified_at' => Carbon::now()]);
        Auth::login($user);
        \request()->session()->regenerate();
    
        return redirect()->intended('/')->with('success', 'Xác thực email thành công.');
    }
    
    public function registerForm() {

        return view('client.pages.register');
    }

    public function register(request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email'=> ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password_confirmation'=>'required',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/','confirmed'],
        ],[

            'name.required' =>'Vui lòng nhập tên',
            'email.required'=>'Vui lòng nhập email',
            'email.unique'=>'Email đã tồn tại',
            'password.min'=>'Mật khẩu phải ít nhất 8 ký tự',
            'password.required'=>'Vui lòng không bỏ trống',
            'password.regex'=>'Bao gồm ít nhất 1 chữ hoa,chữ thường,số',
            'password.confirmed'=>'Mật khẩu không trùng khớp',
            'password_confirmation.required'=>'Vui lòng không bỏ trống',
        ]);
        $user = User::query()->create($data);
        if ($user->email_verification_expires_at && $user->email_verification_expires_at->isFuture()) {
            return redirect()->route('login')->withErrors([
                'error' => 'Email xác thực đã được gửi, vui lòng kiểm tra hộp thư hoặc chờ liên kết hết hạn để gửi lại.',
            ]);
        }

    $user->update([
        'email_verification_expires_at' => Carbon::now()->addMinutes(value: 30)
    ]);
 
        $token = base64_encode($user->email);
        Mail::to($user->email)->send(new VerifyEmail($user->name, $token));
        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng xác thực email.');
    }
}
