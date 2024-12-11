<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();

        return redirect()->route('admin.loginForm')->with('success', 'Đăng xuất thành công');
    }

    public function loginForm()
    {
        return view('admin.layout.account.login');
    }

    public function login(Request $request)
    {
        $maxAttempts = 3;
        $decayMinutes = 15;
        // Kiểm tra nếu người dùng bị khóa tạm thời
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            $minutes = floor($seconds / 60);
            $remainingSeconds = $seconds % 60;

            return back()->withErrors([
                'err' => 'Vui lòng thử lại sau ' . $minutes . ' phút ' . $remainingSeconds . ' giây.',
            ])->onlyInput('email');
        }
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Password không được bỏ trống'
        ]);

        $remember = $request->has('remember');
        if (Auth::attempt($login, $remember)) {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == '1') {
                $workShift = $user->workShift;
                $now = Carbon::now();

                $startTime = Carbon::createFromFormat('H:i:s', $workShift->start_time);
                $endTime = Carbon::createFromFormat('H:i:s', $workShift->end_time);

                if ($endTime->lessThan($startTime)) {
                    if ($now->between($startTime, Carbon::createFromTime(23, 59, 59)) || $now->between(Carbon::createFromTime(0, 0, 0), $endTime)) {
                        return redirect()->intended('admin')->with('success', 'Đăng nhập thành công');
                    }
                } else {
                    if ($now->between($startTime, $endTime)) {
                        return redirect()->intended('admin')->with('success', 'Đăng nhập thành công');
                    }
                }
                Auth::logout();
                return redirect()->route('admin.loginForm')->with('warning', 'Bạn chỉ có thể đăng nhập trong giờ làm việc.');
            }


            if ($user && $user->email_verified_at == null) {
                Auth::logout();
                return back()->withErrors([
                    'err' => 'Email chưa được xác thực!',
                ])->onlyInput('email');
            }

            if ($user->is_active == 0) {
                Auth::logout();
                return back()->withErrors([
                    'err' => 'Tài khoản của bạn hiện tại không hoạt động.',
                ]);
            }

            if ($user->role == 2 || $user->role == 1) {
                $request->session()->put('user_name', $user->name);
                return redirect()->intended('admin')->with('success', 'Đăng nhập thành công');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'err' => 'Bạn không có quyền truy cập vào trang admin',
                ])->onlyInput('err');
            }
        }

        RateLimiter::hit($this->throttleKey($request), $decayMinutes * 60);

        return back()->withErrors([
            'err' => 'Thông tin không chính xác, vui lòng kiểm tra lại',
        ])->onlyInput('err');
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip(); // Tạo khóa duy nhất dựa trên email và địa chỉ IP của người dùng
    }
}
