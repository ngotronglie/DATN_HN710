<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.layout.account.';

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $trashedCount = User::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('users','trashedCount'));
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
        $data['is_active'] ??= 0;
        $data['password'] = Hash::make($request->input('password'));

        if ($request->hasFile('avatar')) {
            $data['avatar'] = Storage::put('users', $request->file('avatar'));
        } else {
            $data['avatar'] = '';
        }      
            User::create($data);
            return redirect()->route('accounts.index')->with('success', 'Thêm mới thành công');
    
        
    }
    

    /**
     * Display the specified resource.
     */
  
    public function show(User $account)
    {
        // dd($account);
        return view(self::PATH_VIEW.__FUNCTION__, compact('account'));
    }

    

    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
      
        return view(self::PATH_VIEW.__FUNCTION__, compact('account'));
    }


    /**
     * Update the specified resource in storage.
     */
    
    public function update(UpdateUserRequest $request, User $account) {
    {
        
        $data=$request->except('avatar');
            $data['is_active']??=0;
            if($request->hasFile('avatar')){
                $data['avatar']=Storage::put('users',$request->file('avatar'));
                if($account->avatar){
                    Storage::delete($account->avatar);  
                }
            }else{
                $data['avatar']=$account->avatar;
            }
            $account->update($data);
            return redirect()->route('accounts.index')->with('success', 'Sửa thành công');
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account) 
{
    $account->delete();
    return redirect()->route('accounts.index')->with('success', 'Xóa mềm thành công');
}

    public function forceDelete($id)
{
    $user = User::withTrashed()->find($id); 
    if ($user) {
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->forceDelete();
        return redirect()->route('accounts.index')->with('success', 'Tài khoản đã được xóa vĩnh viễn.');
    }

    return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại.');
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
    return redirect()->route('accounts.trashed')->with('success', 'Khôi phục thành công');
}

    

}
