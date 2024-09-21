<?php

namespace App\Http\Controllers\Ajax;
use App\Http\Controllers\Controller;
use App\Models\CategoryBlog;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{

    function changeActiveCetegoryBlog(Request $request, CategoryBlog $categoryBlog){
        $id = $request->id; // Lấy ID từ request
       $change = $request->model; // Lấy giá trị model từ request


    // Cập nhật giá trị model cho user có id tương ứng
    $categoryBlog->where('id', $id)->update(['is_active' => $change == 1 ? 0 : 1]);
    }

}


