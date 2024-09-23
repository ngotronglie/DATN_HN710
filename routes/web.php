<?php

use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SizeController;
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

Route::get('admin/login', [LoginController::class, 'loginForm'])->name('admin.loginForm');
Route::post('admin/checkLogin', [LoginController::class, 'login'])->name('admin.checkLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::get('admin/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('admin.forgot');
Route::post('admin/forgot', [ForgotPasswordController::class, 'forgot'])->name('admin.forgot.password');
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');


Route::prefix('admin')->as('admin.')->middleware('isAdmin')->group(function () {
    Route::get('/', function () {
        return view('admin.layout.yeld');
    })->name('dashboard');

    // Các route tùy chỉnh
    Route::delete('/accounts/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('accounts.forceDelete');
    Route::get('accounts/trashed', [UserController::class, 'trashed'])->name('accounts.trashed');
    Route::post('accounts/{user}/restore', [UserController::class, 'restore'])->name('accounts.restore');
    Route::get('accounts/listUser', [UserController::class, 'listUser'])->name('accounts.listUser');

    // Các route resource cho accounts
    Route::resource('accounts', UserController::class);

    // Quản lý các size đã bị xóa mềm
    Route::get('sizes/trashed', [SizeController::class, 'trashed'])->name('sizes.trashed');
    Route::put('sizes/restore/{id}', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::delete('sizes/forceDelete/{id}', [SizeController::class, 'forceDelete'])->name('sizes.forceDelete');

    Route::resource('sizes', SizeController::class);
});
