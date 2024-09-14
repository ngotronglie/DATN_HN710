<?php

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
});

// Quản lý các danh mục đã bị xóa mềm
Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
Route::put('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('categories/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

Route::resource('categories', CategoryController::class);
