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
        $trashedCount = User::onlyTrashed()->count();
        $users = User::where('role', '0')->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'trashedCount', 'users'));
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        if (Gate::denies('delete', $account)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Xóa mềm thành công');
    }

    public function trashed()
    {
        if (Gate::denies('viewTrashed', User::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $trashedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.layout.account.trashed', compact('trashedUsers'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (Gate::denies('restore', $user)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        $user->restore();
        return redirect()->route('admin.accounts.trashed')->with('success', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if (Gate::denies('forceDelete', $user)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->forceDelete();
        return redirect()->route('admin.accounts.trashed')->with('success', 'Tài khoản đã được xóa vĩnh viễn');
    }

    public function myAccount()
    {
        $user = Auth::user();
        return view('admin.layout.account.my_account', compact('user'));
    }

    public function updateMyAcount(request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|regex:/^[0-9]{10}$/',
            'date_of_birth' => 'nullable|date|before:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'date_of_birth.before' => 'Ngày sinh không hợp lệ.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
        ]);
        $data = $request->except('avatar');
        $data['email'] = $user->email;
        $data = $request->except('avatar');
        if ($request->hasFile('avatar')) {

            $data['avatar'] = Storage::put('users', $request->file('avatar'));
            if (!empty($user->avatar) && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
        } else {
            $data['image'] = $user->avatar;
        }
        $user->update($data);
        return redirect()->route('admin.accounts.myAccount')->with('success', 'Cập nhật thông tin thành công');
    }
    
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (empty($request->current_password)) {
            return back()->withErrors(['current_password' => 'Vui lòng nhập mật khẩu hiện tại.']);
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'new_password_confirmation' => 'required|string',
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.regex' => 'Mật khẩu bao gồm chữ in hoa, chữ cái thường và số.',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu mới không trùng khớp.',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống.',
        ]);
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu hiện tại']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::logout();

        return redirect()->route('admin.loginForm')->with('success', 'Cập nhật mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}
