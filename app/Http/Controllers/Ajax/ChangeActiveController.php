<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{
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
}
