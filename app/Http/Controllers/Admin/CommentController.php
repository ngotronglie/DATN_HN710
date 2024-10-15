<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Phương thức để hiển thị danh sách tất cả các bình luận
    public function index()
    {
        // Lấy tất cả bình luận, bao gồm cả thông tin liên quan đến người dùng và sản phẩm thông qua quan hệ 'user' và 'product'
        $comments = Comment::with('user', 'product')->latest()->get(); // Sắp xếp theo thời gian mới nhất

        // Trả về view 'admin.comments.index' và truyền biến $comments cho view
        return view('admin.layout.comment.index', compact('comments'));
    }

    // Phương thức để hiển thị chi tiết của một bình luận cụ thể
    public function show($id)
    {
        // Lấy một bình luận dựa vào ID, bao gồm cả thông tin của người dùng và sản phẩm thông qua quan hệ
        $comment = Comment::with('user', 'product')->findOrFail($id);

        // Trả về view 'admin.comments.show' và truyền biến $comment cho view
        return view('admin.comments.show', compact('comment'));
    }

    // Phương thức để xóa một bình luận

    // Phương thức để chuyển đổi trạng thái hoạt động (is_active) của một bình luận
    public function toggleStatus($id)
    {
        // Tìm bình luận theo ID. Nếu không tìm thấy, trả về lỗi 404
        $comment = Comment::findOrFail($id);

        // Đảo ngược trạng thái của bình luận (nếu đang hoạt động thì chuyển thành không hoạt động, và ngược lại)
        $comment->is_active = !$comment->is_active;

        // Lưu thay đổi
        $comment->save();

        // Sau khi cập nhật, chuyển hướng người dùng về trang danh sách bình luận với thông báo thành công
        return redirect()->route('comments.index')->with('success', 'Cập nhật trạng thái bình luận thành công.');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'content' => 'required|string|max:500',
        // ]);

        if ($this->containsProfanity($request->content)) {
            return 'Bình luận của bạn chứa từ ngữ không phù hợp. Vui lòng chỉnh sửa.';
        }

        // Lưu bình luận
        Comment::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'content' => $request->content,
            'is_active' => $request->is_active, // Đánh dấu bình luận là chưa được duyệt
        ]);

        return 'ok';
    }


    // Hàm kiểm tra từ ngữ thô tục
    private function containsProfanity($content)
    {
        // Danh sách từ ngữ thô tục
        $profanities = ['dmm', 'dmm2', 'hihiha']; // Thay thế bằng từ ngữ thực tế

        foreach ($profanities as $profanity) {
            if (stripos($content, $profanity) !== false) {
                return true; // Trả về true nếu tìm thấy từ ngữ thô tục
            }
        }

        return false; // Không tìm thấy từ ngữ thô tục
    }
}

// app/Http/Controllers/CommentController.php