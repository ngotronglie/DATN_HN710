<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMyAccountRequest;
use App\Models\District;
use App\Models\OrderDetail;
use App\Models\Province;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Ward;
use Carbon\Carbon;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailPassword;
use App\Models\Order;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function loginForm()
    {
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
            'email.email' => 'Email không đúng đinh dạng',
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống',
        ]);

        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {

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

    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect()->route('home')->with('success', 'Đăng xuất thành công');
    }
    public function verify($token)
    {
        $user = User::query()
            ->where('email', base64_decode($token))
            ->whereNull('email_verified_at')
            ->first();

        if (!$user || $user->email_verification_expires_at < Carbon::now()) {
            if ($user) {
                if ($user->is_active == 0) {
                    return redirect('login')->withErrors([
                        'error' => 'Tài khoản của bạn bị khóa.',
                    ]);
                }
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
        $user->update([
            'email_verified_at' => Carbon::now(),
            'email_verification_expires_at' => null
        ]);
        Auth::login($user);

        \request()->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Xác thực email thành công.');
    }

    public function registerForm()
    {

        return view('client.pages.account.register');
    }

    public function register(request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password_confirmation' => 'required',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
        ], [

            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.required' => 'Vui lòng không bỏ trống',
            'password.regex' => 'Bao gồm ít nhất 1 chữ hoa,chữ thường,số',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password_confirmation.required' => 'Vui lòng không bỏ trống',
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

    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
        }
        if ($user->email_verified_at === null) {
            return back()->withErrors(['email' => 'Email chưa được xác thực. Vui lòng xác thực email trước khi yêu cầu đặt lại mật khẩu.']);
        }
        if ($user->is_active == 0) {
            return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa']);
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
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Vui lòng không được bỏ trống',
            'password.string' => 'Mật khẩu phải là chuỗi',
            'password.min' => 'Mật khẩu ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password.regex' => 'Mật khẩu phải có chữ in hoa,chữ thường và số',
            'password_confirmation.required' => 'Vui lòng không bỏ trống'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không hợp lệ']);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công!');
    }

    public function myAccount()
    {
        session()->forget('user_cart');

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $address = $user->address;

        $addressParts = explode(',', $address);

        $vouchers = UserVoucher::with('voucher')->where('user_id', $user->id)->get();

        // $voucherPoint = Voucher::where('points_required', '>', 0)
        //     ->doesntHave('users')  // Điều kiện để loại bỏ các voucher đã tồn tại trong bảng UserVoucher
        //     ->get();

        $voucherPoint = Voucher::where('points_required', '>', 0)
        ->where('is_active', 1)
         ->with('users')
         ->orderBy('id', 'desc')
         ->get();

        $provinces = Province::all();

        $bills = Order::query()->where('user_id', $user->id)->with('voucher')->orderBy('id', 'desc')->get();
        return view('client.pages.account.my_account.my-account', compact('user', 'bills', 'vouchers', 'voucherPoint', 'addressParts', 'provinces'));
    }

    public function orderBillDetail($id)
    {
        session()->forget('user_cart');

        if (Auth::check()) {
            $user = Auth::user();
        }

        $order = Order::with(['orderDetails.productVariant.product', 'voucher'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $address = $order->user_address;

        $addressParts = explode(',', $address);

        $addressData = [
            'province' => isset($addressParts[3]) ? Province::where('code', trim($addressParts[3]))->value('full_name') : null,
            'district' => isset($addressParts[2]) ? District::where('code', trim($addressParts[2]))->value('full_name') : null,
            'ward' => isset($addressParts[1]) ? Ward::where('code', trim($addressParts[1]))->value('full_name') : null,
            'addressDetail' => isset($addressParts[0]) ? $addressParts[0] : null,
        ];

        return view('client.pages.account.my_account.bill-detail', compact('user', 'order', 'addressData'));
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if ($order && $order->status == 1) {
            $order->status = 5;
            $order->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        } else {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }
    }

    public function updateMyAcount(UpdateMyAccountRequest $request, $id)
{
    $user = User::findOrFail($id);
    $province_code = $request->input('provinces');
    $district_code = $request->input('districs');
    $ward_code = $request->input('wards');
    $address = $request->input('address');

    $full_address = $address . ', ' . $ward_code . ', ' . $district_code . ', ' . $province_code;

    $data = $request->only(['phone', 'date_of_birth']);
    $data['address'] = $full_address;

    if ($request->hasFile('avatar')) {
        $data['avatar'] = Storage::put('users', $request->file('avatar'));
        if (!empty($user->avatar) && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }
    } else {
        $data['avatar'] = $user->avatar;
    }

    $user->update($data);

    return redirect()->route('my_account')->with('success', 'Cập nhật thông tin thành công');
}


    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'new_password_confirmation' => 'required|string',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.regex' => 'Mật khẩu bao gồm chữ in hoa, chữ cái thường và số.',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu mới không trùng khớp.',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống.',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu hiện tại.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}
