<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmailPassword;

class ForgotPasswordController extends Controller
{
    public function forgotForm(){
        return view('admin.layout.account.forgotpassword');
    }

    public function forgot(Request $request){
        $request->validate(['email' => 'required|email'],[
            'email.required' => 'Vui lòng nhập email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }
        if ($user->email_verification_expires_at && Carbon::now()->lessThan($user->email_verification_expires_at)) {
            return back()->withErrors(['email' => 'Link xác thực đã được gửi trước đó. Vui lòng kiểm tra email của bạn hoặc thử lại sau.']);
        }
       
       $user->update([
        
        'email_verification_expires_at' => Carbon::now()->addMinutes(30)
    ]);
        // Tạo token và gửi email xác thực
        $token = base64_encode($user->email);
        Mail::to($user->email)->send(new VerifyEmailPassword($user->name, $token));

        return redirect()->route('admin.forgot')->with('success', 'Link xác thực đã được gửi, vui lòng kiểm tra email của bạn.');
    }
    public function verifyEmail($token) {
        $email = base64_decode($token);
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Email không hợp lệ.']);
        }
  
     if (Carbon::now()->greaterThan($user->email_verification_expires_at)) {
        return redirect()->route('admin.forgot')->withErrors(['email' => 'Link xác thực đã hết hạn. Vui lòng yêu cầu gửi lại link.']);
    }
      
        User::where('email', $email)->update(['email_verified_at' => Carbon::now()]);
        return redirect()->route('admin.password.reset', ['token' => $token])->with('success', 'Email đã được xác thực. Bạn có thể đặt lại mật khẩu.');
    }


    public function showResetForm($token)
    {
        // Giải mã token để lấy email
        $email = base64_decode($token);
    
        // Truyền token và email vào view
        return view('admin.layout.account.password', [
            'token' => $token,
            'email' => $email
        ]);
    }
    

    public function reset(Request $request)
    {
        $request->validate([
           
            'password' => ['required','string','min:8','regex:/[A-Z]/','regex:/[a-z]/','regex:/[0-9]/','confirmed'],
        ],[
            
            'password.required'=>'Vui lòng không được bỏ trống',
            'password.min'=>'Mật khẩu ít nhất 8 ký tự',
            'password.confirmed'=>'Mật khẩu không trùng khớp', 
            'password.regex' => 'Mật khẩu phải có chữ in hoa,chữ thường và số', 
        ]);
    
        $user = User::where('email', $request->email)->first();
        
        // Kiểm tra người dùng có tồn tại không
        if (!$user) {
            return back()->withErrors(['email' => 'Email không hợp lệ.']);
        }
    
        // Cập nhật mật khẩu cho người dùng
        $user->password = Hash::make($request->password);
        $user->save();
    
        return redirect()->route('admin.loginForm')->with('success', 'Mật khẩu đã được đổi thành công!');
    }
}
