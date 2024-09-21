<?php

namespace App\Http\Controllers\Ajax;
use App\Http\Controllers\Controller;
use App\Models\CategoryBlog;
use DB;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{

    function changeActiveCetegoryBlog(Request $request, CategoryBlog $categoryBlog)
    {
        $id = $request->id; // Lấy ID từ request
        $change = $request->model; // Lấy giá trị model từ request


        // Cập nhật giá trị model cho user có id tương ứng
        $categoryBlog->where('id', $id)->update(['is_active' => $change == 1 ? 0 : 1]);
    }

    public function changeActiveAllCtgrBls(Request $request, CategoryBlog $categoryBlog)
    {
        $id = $request->id; // Lấy ID từ request
        $active = $request->is_active;
        if ($active == 0) {
            foreach ($id as $categoryBlogId) {
                $categoryBlog->where('id', $categoryBlogId)->update([
                    'is_active' => $active == 0 ? 1 : DB::raw('is_active')
                ]);
            }
        } else {
            foreach ($id as $categoryBlogId) {
                $categoryBlog->where('id', $categoryBlogId)->update([
                    'is_active' => $active == 1 ? 0 : DB::raw('is_active')
                ]);
            }
        }

        return response()->json(data: ['message' => 'Cập nhật thành công']);
    }

}


