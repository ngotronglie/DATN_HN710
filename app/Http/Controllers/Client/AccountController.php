<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function loginForm() {
        // hiển thị form login
        return view('client.pages.account.login');
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
                'error' => 'Bạn đã nhập sai quá nhiều lần. Vui lòng thử lại sau ' . $minutes . ' phút ' . $remainingSeconds . ' giây.',
            ])->onlyInput('email');
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.email'=>'Email không đúng đinh dạng',
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống',
        ]);
        $user = User::withTrashed()->where('email', $credentials['email'])->first();

        if ($user && $user->trashed()) {
            return back()->withErrors([
                'error' => 'Tài khoản của bạn đã bị xóa. Vui lòng liên hệ với quản trị viên.',
            ])->onlyInput('email');
        }
        $remember = $request->has('remember');

            if (Auth::attempt($credentials,$remember)) {
            if (Auth::user()->email_verified_at === null) {
                Auth::logout(); 
                return back()->withErrors([
                    'error' => 'Email chưa được xác minh, vui lòng kiểm tra hộp thư.', 
                ])->onlyInput('email');
            }
    
         
    
            if (Auth::user()->is_active == 0) {
                Auth::logout(); 
                return back()->withErrors([
                    'error' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với quản trị viên.', 
                ]);
            }
    
            RateLimiter::clear($this->throttleKey($request)); 
            $request->session()->regenerate(); 
            return redirect()->route('home')->with('success', 'Đăng nhập thành công'); 
        }
    
        // Tăng số lần thử đăng nhập sai
        RateLimiter::hit($this->throttleKey($request), $decayMinutes * 60);
    
        return back()->withErrors([
            'error' => 'Thông tin không chính xác, vui lòng kiểm tra lại.',
        ])->onlyInput('email');
    }
    
    // Hàm throttle key để lấy khóa dựa trên địa chỉ IP và email
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip(); // Tạo khóa duy nhất dựa trên email và địa chỉ IP của người dùng
    }
    
    public function logout() {
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
            $user->update(['email_verified_at' => Carbon::now(),
            'email_verification_expires_at' => null]);
        Auth::login($user);
        \request()->session()->regenerate();
    
        return redirect()->intended('/')->with('success', 'Xác thực email thành công.');
    }
    
    public function registerForm() {

        return view('client.pages.account.register');
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
       

    $user->update([
        'email_verification_expires_at' => Carbon::now()->addMinutes(value: 30)
    ]);
 
        $token = base64_encode($user->email);
        Mail::to($user->email)->send(new VerifyEmail($user->name, $token));
        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng xác thực email.');
    }
    public function forgotForm()
    {
        return view('client.pages.account.forgotpassword');
    }
    public function forgot(Request $request){
    $request->validate(['email' => 'required|email'], [
        'email.required' => 'Vui lòng nhập email',
        'email.email'=>'Email không đúng định dạng'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
    }
    if ($user->email_verified_at === null) {
        return back()->withErrors(['email' => 'Email chưa được xác thực. Vui lòng xác thực email trước khi yêu cầu đặt lại mật khẩu.']);
    }
    if ($user->email_verification_expires_at && Carbon::now()->lessThan($user->email_verification_expires_at)) {
        return back()->withErrors(['email' => 'Link xác thực đã được gửi trước đó. Vui lòng kiểm tra email của bạn hoặc thử lại sau 30 phút']);
    }
    $user->update([
        'email_verification_expires_at' => Carbon::now()->addMinutes(30)
    ]);

    $token = base64_encode($user->email);
    Mail::to($user->email)->send(new VerifyEmailPassword($user->name, $token, $user->role));

    return redirect()->route('forgot')->with('success', 'Yêu cầu của bạn đã được gửi, vui lòng kiểm tra hộp thư');
}


    public function verifyEmail($token)
    {
        $email = base64_decode($token);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forgot')->withErrors(['email' => 'Email không hợp lệ']);
        }

        if (Carbon::now()->greaterThan($user->email_verification_expires_at)) {
            return redirect()->route('forgot')->withErrors(['email' => 'Link xác thực đã hết hạn. Vui lòng yêu cầu gửi lại link']);
        }

        User::where('email', $email)->update(['email_verified_at' => Carbon::now()]);
        if ($user->role == 0) {
            return redirect()->route('user.password.reset', ['token' => $token])->with('success', 'Email đã được xác thực. Bạn có thể đặt lại mật khẩu');
        } else {
            return redirect()->route('admin.password.reset', ['token' => $token])->with('success', 'Email đã được xác thực. Bạn có thể đặt lại mật khẩu');
        }
    }
    public function showResetForm($token)
    {
        $email = base64_decode($token);
        return view('client.pages.account.password', [
            'token' => $token,
            'email' => $email,
           
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'password_confirmation'=>'required',
        ], [
            'password.required' => 'Vui lòng không được bỏ trống',
            'password.string' => 'Mật khẩu phải là chuỗi',
            'password.min' => 'Mật khẩu ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password.regex' => 'Mật khẩu phải có chữ in hoa,chữ thường và số',
            'password_confirmation.required' =>'Vui lòng không bỏ trống'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không hợp lệ']);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công!');
    }
   public function myAccount(){
    $user = Auth::user();
    if(!$user) {
        return redirect()->route('login');
    }
    return view('client.pages.account.my_account.my-account', compact('user'));
   }
   public function updateMyAcount(request $request,$id){
          $user=User::findOrFail($id);
          $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'date_of_birth' => 'nullable|date|before:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'date_of_birth.before'=>'Ngày sinh không hợp lệ.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại tối đa 10 số.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
        ]);
        $data = $request->except('avatar');
        $data['email'] = $user->email;
          $data = $request->except('avatar');
          if($request->hasFile('avatar')){

            $data['avatar'] = Storage::put('users', $request->file('avatar'));
            if(!empty($user->avatar) && Storage::exists($user->avatar)){
                Storage::delete($user->avatar);
            }
        }else{
            $data['image'] = $user->avatar;
        }
    $user->update($data);
    return redirect()->route('my_account')->with('success', 'Cập nhật thông tin thành công');
   }
   public function updatePassword(Request $request, $id)
   {
       $user = User::findOrFail($id);
       if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
       }
       if (Hash::check($request->new_password, $user->password)) {
        return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu hiện tại']);
    }
          $request->validate([
           'current_password' => 'required|string',
           'new_password_confirmation'=>'required|string',
           'new_password' => ['required', 'string', 'min:8','regex:/[A-Z]/','regex:/[a-z]/','regex:/[0-9]/','confirmed'],
       ], [
           'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
           'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
           'new_password.regex' => 'Mật khẩu bao gồm chữ in hoa, chữ cái thường và số.',
           'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự.',
           'new_password_confirmation'=>'Vui lòng không bỏ trống.',
           'new_password.confirmed' => 'Mật khẩu mới không trùng khớp.',
       ]);
         

         $user->password = Hash::make($request->new_password);
       $user->save();
       return redirect()->route('login')->with('success', 'Cập nhật mật khẩu thành công. Vui lòng đăng nhập lại');
   }
   
}
