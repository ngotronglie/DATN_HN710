<?php

use App\Http\Controllers\VoucherController;
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


Route::get('/vouchers/trashed', [VoucherController::class, 'trashed'])->name('vouchers.trashed');
Route::delete('vouchers/forceDelete/{id}', [VoucherController::class, 'forceDelete'])->name('vouchers.forceDelete');
Route::put('vouchers/restore/{id}', [VoucherController::class, 'restore'])->name('vouchers.restore');
Route::resource(
    'vouchers',VoucherController::class 
);



// {{route('vouchers.index')}}