<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
| 
*/

// Trang chính
Route::get('/', function () {
    return view('admin.layout.yeld');
});

// Các route tùy chỉnh
Route::delete('/accounts/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('accounts.forceDelete');
Route::get('accounts/trashed', [UserController::class, 'trashed'])->name('accounts.trashed');
Route::post('accounts/{user}/restore', [UserController::class, 'restore'])->name('accounts.restore');

// Các route resource cho accounts
Route::resource('accounts', UserController::class);
