<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $data = User::whereIn('role', [1, 2])->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        $trashedCount = User::onlyTrashed()->count();
        $users = User::where('role', 0)->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'trashedCount', 'users'));
    }

    public function listUser()
    {
        $users = User::where('role', 0)->orderBy('id', 'desc')->get();
        return view('admin.layout.account.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->except('avatar');
        $data['password'] = Hash::make($request->input('password'));

        if ($request->hasFile('avatar')) {
            $data['avatar'] = Storage::put('users', $request->file('avatar'));
        } else {
            $data['avatar'] = '';
        }

        User::create($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Thêm mới thành công');
    }


    /**
     * Display the specified resource.
     */

    public function show(User $account)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('account'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $account)
    {
        $data = $request->all();
        $account->update($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Sửa thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Xóa mềm thành công');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->forceDelete();
        return redirect()->route('admin.accounts.trashed')->with('success', 'Tài khoản đã được xóa vĩnh viễn');
    }

    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.layout.account.trashed', compact('trashedUsers'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        return redirect()->route('admin.accounts.trashed')->with('success', 'Khôi phục thành công');
    }
    public function myAccount(){
        $user = Auth::user();
        return view('admin.layout.account.my_account',compact('user'));
    }
}
