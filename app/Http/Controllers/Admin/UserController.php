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

    public function myAccount(){
        $user = Auth::user();
        return view('admin.layout.account.my_account',compact('user'));
    }
}
