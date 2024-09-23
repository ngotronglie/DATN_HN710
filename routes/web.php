<?php

use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\CategoryController;
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
})->name('dashboard');

// Quản lý các danh mục đã bị xóa mềm
Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
Route::put('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('categories/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

Route::resource('categories', CategoryController::class);

//ajax category blog
Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);

//ajax thay doi tat ca cac truong is_active da chon category blog
Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);

