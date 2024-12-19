<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    //category blog
    public function deleteAllCategoryBlog(Request $request)
    {
        $id = $request->id;

        // Kiểm tra xem ID có hợp lệ không
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ', 'totalCountAfter' => CategoryBlog::count()]);
        }

        // Kiểm tra xem các danh mục có tồn tại không
        $categories = CategoryBlog::whereIn('id', $id)->get();
        if ($categories->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục bài viết nào', 'totalCountAfter' => CategoryBlog::count()]);
        }

        // Kiểm tra xem các danh mục có đang được sử dụng trong bài viết nào không
        $blogsUsingCategories = Blog::whereIn('category_blog_id', $id)->exists();
        if ($blogsUsingCategories) {
            return response()->json(['status' => false, 'message' => 'Có bài viết đang sử dụng danh mục này. Không thể xóa!', 'totalCountAfter' => CategoryBlog::count()]);
        }

        // Tiến hành xóa các danh mục bài viết
        $delete = CategoryBlog::whereIn('id', $id)->delete();
        $trashedCount = CategoryBlog::onlyTrashed()->count();
        $totalCountAfter = CategoryBlog::count();

        // Kiểm tra nếu xóa thành công
        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục bài viết thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được xóa.', 'totalCountAfter' => CategoryBlog::count()]);
    }



    //blog
    public function deleteAllBlog(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = Blog::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy bài viết nào']);
        }
        $delete = Blog::whereIn('id', $id)->delete();
        $trashedCount = Blog::onlyTrashed()->count();
        $totalCountAfter = Blog::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa bài viết thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có bài viết nào được xóa.']);
    }

    // Category
    public function deleteCheckedCategori(Request $request)
    {
        $id = $request->id;

        // Kiểm tra nếu $id không hợp lệ
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ', 'totalCountAfter' => Category::count()]);
        }

        // Lấy các danh mục cần xóa
        $categories = Category::whereIn('id', $id)->get();
        if ($categories->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục nào', 'totalCountAfter' => Category::count()]);
        }

        // Kiểm tra xem có bài viết nào đang sử dụng danh mục này không
        $categories = Product::whereIn('category_id', $id)->exists();
        if ($categories) {
            return response()->json(['status' => false, 'message' => 'Có sản phẩm đang sử dụng danh mục này. Không thể xóa!','totalCountAfter' => Category::count()]);
        }

        // Thực hiện xóa các danh mục
        $delete = Category::whereIn('id', $id)->delete();

        // Lấy số liệu sau khi xóa
        $trashedCount = Category::onlyTrashed()->count();
        $totalCountAfter = Category::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục nào được xóa.', 'totalCountAfter' => Category::count()]);
    }


    //notification
    public function deleteCheckedNoti(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $user->notifications()->whereIn('id', $id)->delete();
        $count = $user->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'message' => 'Các thông báo đã được xóa thành công',
            'count' => $count
        ]);
    }


    // product
    public function deleteCheckeProduct(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = Product::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy sản phẩm nào']);
        }
        $delete = Product::whereIn('id', $id)->delete();
        $trashedCount = Product::onlyTrashed()->count();
        $products = Product::paginate(10);

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa sản phẩm thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $products,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có sản phẩm nào được xóa.']);
    }

    // color
    public function deleteCheckeColor(Request $request)
    {
        $id = $request->id;

        // Kiểm tra nếu $id không hợp lệ
        if (empty($id) || !is_array($id)) {
            return response()->json([
                'status' => false,
                'message' => 'ID không hợp lệ',
                'totalCountAfter' => Color::count(),
            ]);
        }

        // Lọc các màu tồn tại trong cơ sở dữ liệu
        $existingColors = Color::whereIn('id', $id)->pluck('id')->toArray();

        if (empty($existingColors)) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy màu nào',
                'totalCountAfter' => Color::count(),
            ]);
        }

        // Kiểm tra xem các màu có đang được sử dụng không
        $productCount = ProductVariant::whereNotNull('color_id')
            ->whereIn('color_id', $existingColors)
            ->count();

        if ($productCount > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Có màu đang được sử dụng trong các sản phẩm. Không thể xóa!',
                'totalCountAfter' => Color::count(),
            ]);
        }

        // Thực hiện xóa các màu
        $delete = Color::whereIn('id', $existingColors)->delete();

        // Số liệu sau khi xóa
        $trashedCount = Color::onlyTrashed()->count();
        $totalCountAfter = Color::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa màu thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không có màu nào được xóa.',
        ]);
    }


    // size
    public function deleteCheckeSize(Request $request)
    {
        $id = $request->id;

        // Kiểm tra nếu $id không hợp lệ
        if (empty($id) || !is_array($id)) {
            return response()->json([
                'status' => false,
                'message' => 'ID không hợp lệ',
                'totalCountAfter' => Size::count(),
            ]);
        }

        // Lọc các kích cỡ hợp lệ
        $existingSizes = Size::whereIn('id', $id)->pluck('id')->toArray();
        if (empty($existingSizes)) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy kích cỡ nào',
                'totalCountAfter' => Size::count(),
            ]);
        }

        // Kiểm tra xem các kích cỡ có đang được sử dụng không
        $usedCount = ProductVariant::whereIn('size_id', $existingSizes)->count();
        if ($usedCount > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Có kích cỡ đang được sử dụng trong các sản phẩm. Không thể xóa!',
                'totalCountAfter' => Size::count(),
            ]);
        }

        // Thực hiện xóa các kích cỡ
        $delete = Size::whereIn('id', $existingSizes)->delete();

        // Lấy số liệu sau khi xóa
        $trashedCount = Size::onlyTrashed()->count();
        $totalCountAfter = Size::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa kích cỡ thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không có kích cỡ nào được xóa.',
            'totalCountAfter' => Size::count(),
        ]);
    }

    // banner
    public function deleteCheckeBanner(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = Banner::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy biểu ngữ nào']);
        }
        $delete = Banner::whereIn('id', $id)->delete();
        $trashedCount = Banner::onlyTrashed()->count();
        $totalCountAfter = Banner::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa biểu ngữ thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có biểu ngữ nào được xóa.']);
    }
}
