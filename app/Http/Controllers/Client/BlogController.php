<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\Voucher;
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
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        $blogs = Blog::with('user', 'categoryBlog')
            ->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) use ($id) {
                $query->whereNull('deleted_at')
                    ->where('id', $id);
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

    public function show($id)
    {
        $blog = Blog::with(['categoryBlog', 'user'])->where('is_active', 1)
            ->whereHas('categoryBlog', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->findOrFail($id);

        $voucher = Voucher::where('is_active', true)
            ->where('end_date', '>=', Carbon::now()->startOfDay())
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->first();


        $blog->increment('view');

        $hotblogs = Blog::with(['categoryBlog', 'user'])
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

        return view('client.pages.blogs.blog-detail', compact('blog', 'hotblogs', 'categoryBlog', 'voucher'));
    }

    public function applyVoucher(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Bạn phải đăng nhập để sử dụng voucher.'], 401);
        }

        $user = Auth::user();
        $voucherCode = $request->input('voucher_code');

        $voucher = Voucher::where('code', $voucherCode)
            ->where('is_active', true)
            ->where('end_date', '>=', now()->startOfDay())
            ->first();

        if ($voucher) {
            if ($voucher->quantity <= 0) {
                return response()->json(['success' => false, 'message' => 'Voucher đã hết số lượng sử dụng.'], 400);
            }

            $existingUserVoucher = UserVoucher::where('user_id', $user->id)
                ->where('voucher_id', $voucher->id)
                ->exists();

            if ($existingUserVoucher) {
                return response()->json(['success' => false, 'message' => 'Bạn đã lưu voucher này rồi.'], 400);
            }

            UserVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'status' => 'not_used',
            ]);

            // $voucher->quantity = $voucher->quantity - 1;
            // $voucher->save();

            return response()->json(['success' => true, 'message' => 'Voucher đã được lưu thành công!']);
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
