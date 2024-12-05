<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\Color;
use App\Models\Product;
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
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = CategoryBlog::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục bài viết nào']);
        }
        $delete = CategoryBlog::whereIn('id', $id)->delete();
        $trashedCount = CategoryBlog::onlyTrashed()->count();
        $totalCountAfter = CategoryBlog::count();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục bài viết thành công',
                'trashedCount' => $trashedCount,
                'totalCountAfter' => $totalCountAfter,
                'delete' => $delete
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được xóa.']);
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
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $blogs = Category::whereIn('id', $id)->get();
        if ($blogs->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục nào']);
        }
        $delete = Category::whereIn('id', $id)->delete();
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

        return response()->json(['status' => false, 'message' => 'Không có danh mục nào được xóa.']);
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
        $totalCountAfter = Product::count();
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
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = Color::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy màu nào']);
        }
        $delete = Color::whereIn('id', $id)->delete();
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

        return response()->json(['status' => false, 'message' => 'Không có màu nào được xóa.']);
    }

    // size
    public function deleteCheckeSize(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }
        $requestRemove = Size::whereIn('id', $id)->get();
        if ($requestRemove->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy kích cỡ nào']);
        }
        $delete = Size::whereIn('id', $id)->delete();
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

        return response()->json(['status' => false, 'message' => 'Không có kích cỡ nào được xóa.']);
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
