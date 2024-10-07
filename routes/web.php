<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryBlogController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\ClientController;

use App\Http\Controllers\Ajax\DeleteController;
use App\Http\Controllers\User\AccountController;
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

// ----------------------------CLIENT ROUTES--------------------------------

Route::get('/', [ClientController::class, 'index'])->name('home');

Route::get('/contact', function () {
    return view('client.pages.contact');
});
Route::get('/blog', function () {
    return view('client.pages.blog');
});
Route::get('/blog-detail', function () {
    return view('client.pages.blog-detail');
});
Route::get('/shop', [ClientController::class, 'shop']);
Route::get('shop/{id}', [ClientController::class, 'shop_danh_muc'])->name('shop_danh_muc');
Route::get('/wishlist', function () {
    return view('client.pages.wishlist');
});
Route::get('/cart', function () {
    return view('client.pages.cart');
});
Route::get('/checkout', function () {
    return view('client.pages.checkout');
});

Route::get('/about', function () {
    return view('client.pages.about');
});

Route::get('/login', [AccountController::class, 'loginForm']);
Route::post('/login', [AccountController::class, 'login'])->name('login');
 Route::post('user/logout', [AccountController::class, 'logout'])->name('user.logout');
 Route::get('/verify/{token}', [AccountController::class, 'verify'])->name('verify');
 Route::get('/register', [AccountController::class, 'registerForm']);
 Route::post('/register', [AccountController::class, 'register'])->name('register');


Route::get('/forgotpassword', function () {
    return view('client.pages.forgotpassword');
})->name('forgotpassword');

// ----------------------------END CLIENT ROUTES--------------------------------


Route::get('admin/login', [LoginController::class, 'loginForm'])->name('admin.loginForm');
Route::post('admin/checkLogin', [LoginController::class, 'login'])->name('admin.checkLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::get('admin/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('admin.forgot');
Route::post('admin/forgot', [ForgotPasswordController::class, 'forgot'])->name('admin.forgot.password');
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');

//
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.layout.yeld');
    })->name('dashboard');

    // Các route tùy chỉnh
    Route::get('/accounts/my_account',[UserController::class,'myAccount'])->name('accounts.myAccount');
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

    // Quản lý các sản phẩm đã bị xóa mềm
    Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
    Route::put('products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/forceDelete/{id}', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    Route::resource('products', ProductController::class);

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
    
    // Quản lý các banner đã bị xóa mềm
    Route::get('banners/trashed', [BannerController::class, 'trashed'])->name('banners.trashed');
    Route::put('banners/restore/{id}', [BannerController::class, 'restore'])->name('banners.restore');
    Route::delete('banners/forceDelete/{id}', [BannerController::class, 'forceDelete'])->name('banners.forceDelete');

    Route::resource('banners', BannerController::class);
});

//ajax category
Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);
Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);
//ajax product
Route::post('products/ajax/changeActiveProduct', [ChangeActiveController::class, 'changeActiveProduct']);
Route::post('products/ajax/changeAllActiveProduct', [ChangeActiveController::class, 'changeActiveAllProduct']);
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
//ajax xoa cac muc da chon categoryblog
Route::delete('categoryBlogs/ajax/deleteAllCategoryBlog', [DeleteController::class, 'deleteAllCategoryBlog']);
//update count thung rac
Route::get('categoryBlogs/ajax/trashedCount', [CategoryBlogController::class, 'trashedCount']);
//ajax banner
Route::post('banners/ajax/changeActiveBanner', [ChangeActiveController::class, 'changeActiveBanner']);
Route::post('banners/ajax/changeAllActiveBanner', [ChangeActiveController::class, 'changeActiveAllBanner']);
//ajax blog
Route::post('blogs/ajax/changeActiveBlog', [ChangeActiveController::class, 'changeActiveBlog']);
Route::post('blogs/ajax/changeAllActiveBlog', [ChangeActiveController::class, 'changeActiveAllBlog']);
//ajax xoa cac muc da chon blog
Route::delete('blogs/ajax/deleteAllBlog', [DeleteController::class, 'deleteAllBlog']);
//update count thung rac
Route::get('blogs/ajax/trashedCount', [BlogController::class, 'trashedCount']);
