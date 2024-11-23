<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.layout.account.';

    public function index()
    {
        if (Gate::denies('viewAny', User::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $data = User::whereIn('role', ['1', '2'])->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        $users = User::where('role', '0')->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'users'));
    }

    public function listUser()
    {
        if (Gate::denies('viewAny', User::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $users = User::where('role', '0')->orderBy('id', 'desc')->get();
        return view('admin.layout.account.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', User::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if (Gate::denies('create', User::class)) {
            return redirect()->route('admin.accounts.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->except('avatar');
        $data['password'] = Hash::make($request->input('password'));

        if ($request->hasFile('avatar')) {
            $data['avatar'] = Storage::put('users', $request->file('avatar'));
        } else {
            $data['avatar'] = '';
        }

        $data['email_verified_at'] = now();
        User::create($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Thêm mới thành công');
    }


    /**
     * Display the specified resource.
     */

    public function show(User $account)
    {
        if (Gate::denies('view', $account)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('account'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        if (Gate::denies('update', $account)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $account)
    {
        if (Gate::denies('update', $account)) {
            return redirect()->route('admin.accounts.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        if ($account->email_verified_at == null) {
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = $account->email_verified_at;
        }
        $account->update($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Sửa thành công');
    }

    public function myAccount()
    {
        return view('admin.layout.account.my_account');
    }

    public function updateMyAcount(request $request)
    {
        $request->validate(
            [
                'address' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^[0-9]{10}$/',
                'date_of_birth' => 'required|date|before:today',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'address.required' => 'Địa chỉ là bắt buộc',
                'address.max' => 'Tối đa 255 kí tự',
                'phone.required' => 'Số điện thoại là bắt buộc',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'avatar.image' => 'Tệp tải lên phải là hình ảnh',
                'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif',
                'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB',
                'date_of_birth.required' => 'Ngày sinh là bắt buộc',
                'date_of_birth.date' => 'Ngày sinh không hợp lệ',
                'date_of_birth.before' => 'Ngày sinh không được là ngày hiện tại',
            ]
        );
        $user = User::findOrFail(auth()->user()->id);

        $data = $request->only(['phone', 'address', 'date_of_birth']);
        if ($request->hasFile('avatar')) {

            $data['avatar'] = Storage::put('users', $request->file('avatar'));
            if (!empty($user->avatar) && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
        } else {
            $data['avatar'] = $user->avatar;
        }

        $user->update($data);
        return redirect()->route('admin.accounts.myAccount')->with('success', 'Cập nhật thông tin thành công');
    }

    public function showChangePasswordForm()
    {
        return view('admin.layout.account.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'new_password_confirmation' => 'required|string',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.regex' => 'Mật khẩu bao gồm chữ in hoa, chữ cái thường và số',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự',
            'new_password.confirmed' => 'Mật khẩu mới không trùng khớp',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        if (Hash::check($request->new_password, auth()->user()->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu hiện tại']);
        }

        // Cập nhật mật khẩu mới
        $user = User::findOrFail(auth()->user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::logout();

        return redirect()->route('admin.loginForm')->with('success', 'Cập nhật mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}
