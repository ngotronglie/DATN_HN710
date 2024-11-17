<?php

use App\Http\Controllers\Admin\AdminDashboardController;
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
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Ajax\ShopAjaxController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Ajax\DeleteController;
use App\Http\Controllers\Ajax\ChangeActiveController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Client\AccountController;

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

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/category/{id}', [ShopController::class, 'showByCategory'])->name('shops.category');
Route::get('/shops/{slug}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/ajax/shops/{slug}', [ShopController::class, 'showAjax']);
//Route::get('shop/ajax/getSizePrice', [ShopController::class, 'getSizePrice']);
Route::get('shop/ajax/getSizePriceDetail', [ShopAjaxController::class, 'getSizePriceDetail']);
Route::get('shop/ajax/getSizePriceDetail2', [ShopAjaxController::class, 'getSizePriceDetail']);

Route::get('/shop-search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/shop-filter', [ShopController::class, 'filter'])->name('shop.filter');

//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/ajax/addToCart', [CartController::class, 'addToCart']);
Route::delete('/ajax/deleteToCartHeader', [CartController::class, 'deleteToCart']);
Route::post('/ajax/updateQuantityCart', [CartController::class, 'updateQuantity']);

//sản phẩm yêu thích
Route::get('/san-pham-yeu-thich', [FavoriteController::class, 'index'])->name('favorite_Prd.index');
Route::post('/ajax/addToCart', [CartController::class, 'addToCart']);
Route::post('/ajax/addToFavorite', [FavoriteController::class, 'addToFavorite']);
Route::delete('/ajax/deleteToFavorite', [FavoriteController::class, 'deleteToFavorite']);

// Blog
Route::get('/blogs', [ClientBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/category/{id}', [ClientBlogController::class, 'getBlogCategory'])->name('blogs.category');
Route::get('/blogs/{id}', [ClientBlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs-search', [ClientBlogController::class, 'search'])->name('blogs.search');

// Contact
Route::get('/contact', function () {
    return view('client.pages.contact');
});
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Tài khoản
Route::middleware('guest')->group(function () {
    Route::get('/login', [AccountController::class, 'loginForm'])->name('login');
    Route::post('/login', [AccountController::class, 'login'])->name('login');
    Route::get('/register', [AccountController::class, 'registerForm']);
    Route::post('/register', [AccountController::class, 'register'])->name('register');
    Route::get('/forgot', [AccountController::class, 'forgotForm'])->name('forgot');
    Route::post('/forgot', [AccountController::class, 'forgot'])->name('forgot.password');
    Route::get('verify-email/{token}', [AccountController::class, 'verifyEmail'])->name('verify.email');
    Route::get('user/password/reset/{token}', [AccountController::class, 'showResetForm'])->name('user.password.reset');
    Route::post('user/password/reset', [AccountController::class, 'reset'])->name('user.password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('user/logout', [AccountController::class, 'logout'])->name('user.logout');
    Route::get('/my_account', [AccountController::class, 'myAccount'])->name('my_account');
    Route::post('/my_acount/update/{id}', [AccountController::class, 'updateMyAcount'])->name('updateMyAcount');
    Route::post('/my_acount/update-password/{id}', [AccountController::class, 'updatePassword'])->name('user.updatePassword');
});

Route::get('/verify/{token}', [AccountController::class, 'verify'])->name('verify');



// ----------------------------END CLIENT ROUTES--------------------------------

Route::middleware('guest')->group(function () {
    Route::get('admin/login', [LoginController::class, 'loginForm'])->name('admin.loginForm');
    Route::post('admin/checkLogin', [LoginController::class, 'login'])->name('admin.checkLogin');
    Route::get('admin/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('admin.forgot');
    Route::post('admin/forgot', [ForgotPasswordController::class, 'forgot'])->name('admin.forgot.password');
    Route::get('admin/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');
});
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

//middleware(['auth', 'isAdmin'])
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Các route tùy chỉnh
    Route::get('/accounts/my_account', [UserController::class, 'myAccount'])->name('accounts.myAccount');
    Route::post('accounts/my_account/{id}', [UserController::class, 'updateMyAcount'])->name('accounts.updateMyAccount');
    Route::post('/accounts/update-password/{id}', [UserController::class, 'updatePassword'])->name('accounts.updatePassword');

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

    // Quản lý bình luận
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    // Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');

    // Quản lí banner
    Route::resource('banners', BannerController::class);

    //Quản lý đơn hàng
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/{order_id}/order-detail', [OrderController::class, 'detail'])->name('order.detail');
    Route::get('order/confirm/{order_id}', [OrderController::class, 'confirmOrder'])->name('order.confirmOrder');
    Route::get('order/ship/{order_id}', [OrderController::class, 'shipOrder'])->name('order.shipOrder');
    Route::get('order/confirm-shipping/{order_id}', [OrderController::class, 'confirmShipping'])->name('order.confirmShipping');
    Route::get('order/cancel/{order_id}', [OrderController::class, 'cancelOrder'])->name('order.cancelOrder');

    Route::get('order-print/{checkout_code}', [OrderController::class, 'print_order'])->name('order.printOrder');

    // Thống kê
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('statistics/show', [StatisticsController::class, 'showStatistics'])->name('statistics.show');
});

//ajax category
Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);
Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);
//ajax product
Route::post('products/ajax/changeActiveProduct', [ChangeActiveController::class, 'changeActiveProduct']);
Route::post('products/ajax/changeAllActiveProduct', [ChangeActiveController::class, 'changeActiveAllProduct']);
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
//ajax comment
Route::post('comments/ajax/changeActiveComment', [ChangeActiveController::class, 'changeActiveComment']);
Route::post('comments/ajax/changeAllActiveComment', [ChangeActiveController::class, 'changeActiveAllComment']);
//ajax blog
Route::post('blogs/ajax/changeActiveBlog', [ChangeActiveController::class, 'changeActiveBlog']);
Route::post('blogs/ajax/changeAllActiveBlog', [ChangeActiveController::class, 'changeActiveAllBlog']);
//ajax xoa cac muc da chon blog
Route::delete('blogs/ajax/deleteAllBlog', [DeleteController::class, 'deleteAllBlog']);
//update count thung rac
Route::get('blogs/ajax/trashedCount', [BlogController::class, 'trashedCount']);
