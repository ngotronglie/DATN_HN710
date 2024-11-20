<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\Voucher;
use App\Models\User;
use App\Models\UserVoucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });

        $blogs = (clone $blogQuery)
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->orderBy('blogs_count', 'DESC')
            ->get();


        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }


    public function getBlogCategory($id)
    {

        $hotblogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        $blogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) use ($id) {
                $query->whereNull('deleted_at')
                    ->where('id', $id);
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->orderBy('blogs_count', 'DESC')
            ->get();

        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog'));
    }

    // public function show($id)
    // {
    //     $blogQuery = Blog::with(['categoryBlog', 'user'])
    //         ->where('is_active', 1)
    //         ->whereHas('categoryBlog', function ($query) {
    //             $query->where('is_active', 1)
    //                 ->whereNull('deleted_at');
    //         })
    //         ->whereHas('user', function ($query) {
    //             $query->whereNull('deleted_at');
    //         });

    //     $blog = (clone $blogQuery)->findOrFail($id);

    //     $blog->increment('view');

    //     $hotblogs = (clone $blogQuery)
    //         ->orderBy('view', 'desc')
    //         ->take(6)
    //         ->get();

    //     $categoryBlog = CategoryBlog::withCount([
    //         'blogs' => function ($query) {
    //             $query->where('is_active', 1);
    //         }
    //     ])
    //         ->where('is_active', 1)
    //         ->orderBy('blogs_count', 'DESC')
    //         ->get();


    //     return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog'));
    // }

    public function show($id){
    // Truy vấn bài viết và thông tin liên quan
    $blog = Blog::with(['categoryBlog', 'user'])->where('is_active', 1)
        ->whereHas('categoryBlog', function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        })
        ->whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->findOrFail($id);

        $voucher = Voucher::where('is_active', true)
        ->where('end_date', '>=', Carbon::now()->startOfDay())  
        ->inRandomOrder() 
        ->first();  
       
    // Tăng số lượt xem của bài viết
    $blog->increment('view');

    // Lấy các bài viết nổi bật
    $hotblogs = Blog::with(['categoryBlog', 'user'])
        ->orderBy('view', 'desc')
        ->take(6)
        ->get();

    // Lấy danh mục bài viết
    $categoryBlog = CategoryBlog::withCount([
        'blogs' => function ($query) {
            $query->where('is_active', 1);
        }
    ])
        ->where('is_active', 1)
        ->orderBy('blogs_count', 'DESC')
        ->get();

    return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog', 'voucher'));
}
public function applyVoucher(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Bạn phải đăng nhập để sử dụng voucher.'], 401);
    }

    $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
    $voucherCode = $request->input('voucher_code'); // Lấy mã voucher từ request

    // Kiểm tra xem voucher có tồn tại và còn hạn sử dụng không
    $voucher = Voucher::where('code', $voucherCode)
        ->where('is_active', true)
        ->where('end_date', '>=', now()->startOfDay())
        ->first();

    if ($voucher) {
        // Kiểm tra xem người dùng đã sử dụng voucher này chưa
        $existingUserVoucher = UserVoucher::where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($existingUserVoucher) {
            return response()->json(['success' => false, 'message' => 'Bạn đã sử dụng voucher này rồi.'], 400);
        }

        // Lưu voucher vào bảng user_vouchers
        UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'status' => 'applied', // Hoặc 'used', tùy theo logic của bạn
        ]);

        return response()->json(['success' => true, 'message' => 'Voucher đã được áp dụng thành công!']);
    }

    return response()->json(['success' => false, 'message' => 'Voucher không hợp lệ hoặc đã hết hạn.'], 400);
}




    public function search(Request $request)
    {
        $input = $request->input('searchBlog');

        $blogQuery = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            });


        $hotblogs = (clone $blogQuery)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();

        $blogs = $blogQuery->where(function ($query) use ($input) {
            $query->where('title', 'LIKE', "%{$input}%")
                ->orWhere('content', 'LIKE', "%{$input}%");
        })->paginate(6);

        $categoryBlog = CategoryBlog::withCount([
            'blogs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('is_active', 1)
            ->orderBy('blogs_count', 'DESC')
            ->get();

        return view('client.pages.blogs.blog', compact('blogs', 'hotblogs', 'categoryBlog', 'input'));
    }
}
