<?php

use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryBlogController;
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


Route::get('/', function () {
    return view('admin.layout.yeld');
});


// Quản lý các danh mục đã bị xóa mềm
Route::get('category_blogs/trashed', [CategoryBlogController::class, 'trashed'])->name('category_blogs.trashed');
Route::put('category_blogs/restore/{id}', [CategoryBlogController::class, 'restore'])->name('category_blogs.restore');
Route::delete('category_blogs/forceDelete/{id}', [CategoryBlogController::class, 'forceDelete'])->name('category_blogs.forceDelete');

Route::resource('category_blogs', CategoryBlogController::class);
Route::resource('blogs', BlogController::class);


//ajax category blog
Route::post('ajax/changeActiveCategoryBlog', [ChangeActiveController::class, 'changeActiveCetegoryBlog']);
//ajax thay doi tat ca cac truong is_active da chon category blog
Route::post('ajax/changeActiveAllCaregoryBlogs', [ChangeActiveController::class, 'changeActiveAllCtgrBls']);


