<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController; // Import the ColorController

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
Route::get('colors/trashed', [ColorController::class, 'trashed'])->name('colors.trashed');
Route::put('colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
Route::delete('colors/forceDelete/{id}', [ColorController::class, 'forceDelete'])->name('colors.forceDelete');

Route::resource('colors', ColorController::class);