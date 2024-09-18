<?php

use App\Http\Controllers\SizeController;
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

// Quản lý các size đã bị xóa mềm
Route::get('sizes/trashed', [SizeController::class, 'trashed'])->name('sizes.trashed');
Route::put('sizes/restore/{id}', [SizeController::class, 'restore'])->name('sizes.restore');
Route::delete('sizes/forceDelete/{id}', [SizeController::class, 'forceDelete'])->name('sizes.forceDelete');

Route::resource('sizes' , SizeController::class);
