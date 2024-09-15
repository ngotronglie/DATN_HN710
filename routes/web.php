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


Route::get('/', function () {
    return view('admin.layout.yeld');
});
//  Route::resource('accounts', UserController::class);
Route::get('/accounts',[UserController::class,'index'])->name('accounts.index');
Route::get('/accounts/create',[UserController::class,'create'])->name('accounts.create');
Route::get('/accounts/{id}/show',[UserController::class,'show'])->name('accounts.show');
Route::get('/accounts/{id}/edit',[UserController::class,'edit'])->name('accounts.edit');
Route::post('/accounts/store',[UserController::class,'store'])->name('accounts.store');
Route::put('/accounts/{id}/update',[UserController::class,'update'])->name('accounts.update');
Route::delete('/accounts/{id}/softDelete',[UserController::class,'softDelete'])->name('accounts.softDelete');
Route::delete('/accounts/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('accounts.forceDelete');

Route::get('accounts/trashed', [UserController::class, 'trashed'])->name('accounts.trashed');
Route::post('accounts/{user}/restore', [UserController::class, 'restore'])->name('accounts.restore');

