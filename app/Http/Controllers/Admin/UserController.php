<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.layout.account.';

    public function index()
    {
        $users = User::latest('id')->get();
        // dd($users);
        return view(self::PATH_VIEW . __FUNCTION__, compact('users'));
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
   
    

}
