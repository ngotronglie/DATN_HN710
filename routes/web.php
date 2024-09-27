<?php

use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryBlogController;

use App\Http\Controllers\Ajax\ChangeActiveController;


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

//
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

    // Quản lý các size đã bị xóa mềm
    Route::get('colors/trashed', [ColorController::class, 'trashed'])->name('colors.trashed');
    Route::put('colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
    Route::delete('colors/forceDelete/{id}', [ColorController::class, 'forceDelete'])->name('colors.forceDelete');

    Route::resource('colors', ColorController::class);

    // Vouchers
    Route::get('/vouchers/trashed', [VoucherController::class, 'trashed'])->name('vouchers.trashed');
    Route::delete('vouchers/forceDelete/{id}', [VoucherController::class, 'forceDelete'])->name('vouchers.forceDelete');
    Route::put('vouchers/restore/{id}', [VoucherController::class, 'restore'])->name('vouchers.restore');

    Route::resource('vouchers', VoucherController::class);

    // Quản lý các danh mục đã bị xóa mềm
    Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::put('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    Route::resource('categories', CategoryController::class);

    // Quản lý các danh mục đã bị xóa mềm
    Route::get('category_blogs/trashed', [CategoryBlogController::class, 'trashed'])->name('category_blogs.trashed');
    Route::put('category_blogs/restore/{id}', [CategoryBlogController::class, 'restore'])->name('category_blogs.restore');
    Route::delete('category_blogs/forceDelete/{id}', [CategoryBlogController::class, 'forceDelete'])->name('category_blogs.forceDelete');

    Route::resource('category_blogs', CategoryBlogController::class);

    //Quản lý bài viết xóa mềm
    Route::get('blogs/trashed', [BlogController::class, 'trashed'])->name('blogs.trashed');
    Route::put('blogs/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('blogs/forceDelete/{id}', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');
    Route::resource('blogs', BlogController::class);

    //ajax category
    Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);
    Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);
    //ajax size
    Route::post('sizes/ajax/changeActiveSize', [ChangeActiveController::class, 'changeActiveSize']);
    Route::post('sizes/ajax/changeAllActiveSize', [ChangeActiveController::class, 'changeActiveAllSize']);
    //ajax color
    Route::post('colors/ajax/changeActiveColor', [ChangeActiveController::class, 'changeActiveColor']);
    Route::post('colors/ajax/changeAllActiveColor', [ChangeActiveController::class, 'changeActiveAllColor']);
    //ajax account
    Route::post('accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
    Route::post('accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
    Route::post('accounts/accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
    Route::post('accounts/accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
    //ajax category blog
    Route::post('category_blogs/ajax/changeActiveCategoryBlog', [ChangeActiveController::class, 'changeActiveCategoryBlog']);
    Route::post('category_blogs/ajax/changeAllActiveCategoryBlog', [ChangeActiveController::class, 'changeActiveAllCategoryBlog']);

    //ajax blog
    Route::post('blogs/ajax/changeActiveBlog', [ChangeActiveController::class, 'changeActiveBlog']);
    Route::post('blogs/ajax/changeAllActiveBlog', [ChangeActiveController::class, 'changeActiveAllBlog']);
});
