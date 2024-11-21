<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    //category blog
    public function deleteAllCategoryBlog(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }
        // Lấy các bản ghi dựa trên ID
        $categoryBlogs = CategoryBlog::whereIn('id', $id)->get();

        if ($categoryBlogs->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục bài viết nào'], 404);
        }
        $delete = CategoryBlog::whereIn('id', $id)->delete();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục bài viết thành công',
                'delete' => $delete
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được xóa.'], 500);
    }


    public function deleteAllBlog(Request $request)
    {
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }
        // Lấy các bản ghi dựa trên ID
        $blogs = Blog::whereIn('id', $id)->get();

        if ($blogs->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy bài viết nào'], 404);
        }
        $delete = Blog::whereIn('id', $id)->delete();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa bài viết thành công',
                'delete' => $delete
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có bài viết nào được xóa.'], 500);
    }

    // Category

    public function deleteAllCategory(Request $request)
    {

    }


    //notification
    public function deleteCheckedNoti(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $user->notifications()->whereIn('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Các thông báo đã được xóa thành công',
        ]);
        }

}
