<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\Category;
use App\Models\User;
use App\Models\CategoryBlog;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{
    // Category
    public function changeActiveCategory(Request $request)
    {
        $id = $request->id;

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Danh mục không tìm thấy']);
        }

        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'status' => true,
            'active' => $category->is_active,
            'message' => 'Cập nhật trạng thái danh mục thành công',
        ]);
    }


    public function changeActiveAllCategory(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền']);
        }

        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Category::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục nào được cập nhật']);
    }

    // Product
    public function changeActiveProduct(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }

        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'status' => true,
            'active' => $product->is_active,
            'message' => 'Cập nhật trạng thái sản phẩm  thành công',
        ]);
    }

    public function changeActiveAllProduct(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền']);
        }

        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Product::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái sản phẩm thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có sản phẩm nào được cập nhật']);
    }

    // Account
    public function changeActiveAccount(Request $request)
    {
        $id = $request->id;

        $item = User::find($id);
        if (!$item) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy tài khoản']);
        }

        $item->is_active = !$item->is_active;
        $item->save();

        return response()->json([
            'status' => true,
            'active' => $item->is_active,
            'message' => 'Cập nhật trạng thái tài khoản thành công',
        ]);
    }


    public function changeActiveAllAccount(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = User::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái tài khoản thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có tài khoản nào được cập nhật']);
    }

    // Category blog
    public function changeActiveCategoryBlog(Request $request)
    {
        $id = $request->id;

        $item = CategoryBlog::find($id);
        if (!$item) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy danh mục bài viết']);
        }

        $item->is_active = !$item->is_active;
        $item->save();

        return response()->json([
            'status' => true,
            'active' => $item->is_active,
            'message' => 'Cập nhật trạng thái danh mục bài viết thành công',
        ]);
    }

    public function changeActiveAllCategoryBlog(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền']);
        }
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = CategoryBlog::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục bài viết thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được cập nhật']);
    }

    // blog
    public function changeActiveBlog(Request $request)
    {
        $id = $request->id;

        $item = Blog::find($id);
        if (!$item) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy bài viết']);
        }

        $item->is_active = !$item->is_active;
        $item->save();

        return response()->json([
            'status' => true,
            'active' => $item->is_active,
            'message' => 'Cập nhật trạng thái bài viết thành công',
        ]);
    }

    public function changeActiveAllBlog(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền']);
        }
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Blog::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục bài viết thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục bài viết nào được cập nhật']);
    }

    // Banner
    public function changeActiveBanner(Request $request)
    {
        $id = $request->id;

        $item = Banner::find($id);
        if (!$item) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy biểu ngữ']);
        }

        $item->is_active = !$item->is_active;
        $item->save();

        return response()->json([
            'status' => true,
            'active' => $item->is_active,
            'message' => 'Cập nhật trạng thái biểu ngữ thành công',
        ]);
    }

    public function changeActiveAllBanner(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền']);
        }
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Banner::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái biểu ngữ thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có biểu ngữ nào được cập nhật']);
    }

    // Comment
    public function changeActiveComment(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['status' => false, 'message' => 'bình luận không tìm thấy']);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $comment->update(['is_active' => $newActive]);

        if ($updated) {
            if ($comment->parent_id === null) {
                Comment::where('parent_id', $id)->update(['is_active' => $newActive]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bình luận thành công',
                'newStatus' => $newActive,
                'comment' => $comment
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại']);
        }
    }

    public function changeActiveAllComment(Request $request)
    {
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ']);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Comment::whereIn('id', $id)->update(['is_active' => $newActive]);

        Comment::whereIn('parent_id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bình luận thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không có comment nào được cập nhật']);
    }
}
