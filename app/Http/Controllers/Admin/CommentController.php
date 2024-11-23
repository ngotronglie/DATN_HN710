<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function index()
    {
        $products = Product::withCount([
            'comments', // Đếm tổng số bình luận
            'comments as active_comments_count' => function ($query) {
                $query->where('is_active', 1); // Đếm số bình luận bật
            },
            'comments as inactive_comments_count' => function ($query) {
                $query->where('is_active', 0); // Đếm số bình luận tắt
            }
        ])
            ->whereHas('category', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('comments_count', 'desc')
            ->get();

        return view('admin.layout.comments.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        if (!$product || !$product->category) {
            abort(404);
        }

        $comments = Comment::with('user')
            ->withCount('children')
            ->where('product_id', $id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($comments->isEmpty()) {
            return back()->with('warning', 'Không có bình luận nào cho sản phẩm này');
        }

        return view('admin.layout.comments.show', compact('comments', 'product'));
    }

    public function showChildren($id)
    {
        $childComments = Comment::with(['user', 'parent.user'])
            ->where('parent_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($childComments->isEmpty()) {
            return back()->with('warning', 'Không có bình luận con nào cho bình luận cha này');
        }

        $parentComment = $childComments->first()->parent ?? null;

        $product = $childComments->first()->product ?? null;

        if (!$product || !$product->category) {
            abort(404);
        }

        return view('admin.layout.comments.showChildren', compact('childComments', 'parentComment', 'product'));
    }
}
