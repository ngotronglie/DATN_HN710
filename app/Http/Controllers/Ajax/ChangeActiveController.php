<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;
use App\Models\CategoryBlog;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{
    // Category
    public function changeActiveCategory(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Danh mục không tìm thấy'], 404);
        }

        // Cập nhật trạng thái is_active
        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $category->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục thành công',
                'newStatus' => $newActive,
                'category' => $category
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllCategory(Request $request)
    {
        $id = $request->id; // Lấy ID từ request
        $active = $request->is_active;
        // Kiểm tra xem có ID nào không
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Category::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated // Trả về số lượng category được cập nhật
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục nào được cập nhật'], 404);
    }

    // Size
    public function changeActiveSize(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $size = Size::find($id);
        if (!$size) {
            return response()->json(['status' => false, 'message' => 'Size không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $size->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái size thành công',
                'newStatus' => $newActive,
                'category' => $size
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllSize(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Size::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái size thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có size nào được cập nhật'], 404);
    }

    // Color
    public function changeActiveColor(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $color = Color::find($id);
        if (!$color) {
            return response()->json(['status' => false, 'message' => 'Color không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $color->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái color thành công',
                'newStatus' => $newActive,
                'category' => $color
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllColor(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Color::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái color thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có color nào được cập nhật'], 404);
    }

    // Account
    public function changeActiveAccount(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $account = User::find($id);
        if (!$account) {
            return response()->json(['status' => false, 'message' => 'Tài khoản không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $account->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái tài khoản thành công',
                'newStatus' => $newActive,
                'category' => $account
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllAccount(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = User::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái tài khoản thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có tài khoản nào được cập nhật'], 404);
    }

    // Category blog
    public function changeActiveCategoryBlog(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $categoryBlog = CategoryBlog::find($id);
        if (!$categoryBlog) {
            return response()->json(['status' => false, 'message' => 'Danh mục bài viết không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $categoryBlog->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục bài viết thành công',
                'newStatus' => $newActive,
                'category' => $categoryBlog
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllCategoryBlog(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = CategoryBlog::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục bài viết thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được cập nhật'], 404);
    }
}