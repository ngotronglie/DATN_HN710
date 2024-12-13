<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ShiftController extends Controller
{
    const PATH_VIEW = 'admin.layout.shift.';

    public function index()
    {
        $shift = WorkShift::with('users')->get();


        return view(self::PATH_VIEW . __FUNCTION__,compact('shift'));
    }

    public function create()
    {
    
        return view(self::PATH_VIEW . __FUNCTION__);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'shift_name' => [
                'required',
                'string',
                'max:255',
                'unique:work_shifts'
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ], [
            'shift_name.required'=>'Vui lòng nhập tên ca làm việc',
            'shift_name.unique' => 'Tên ca làm việc đã tồn tại ',
            'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
            'end_time.required'=>'Thời gian kết thúc là bắt buộc'
        ]);
    
        $exists = WorkShift::where('start_time', $request->start_time)
        ->where('end_time', $request->end_time)
        ->exists();

    if ($exists) {
        return back()->withErrors(['end_time' => 'Thời gian bắt đầu và kết thúc đã tồn tại trong hệ thống.'])->withInput();
    }

    
        WorkShift::create($validatedData);
            return redirect()->route('admin.shift.index')->with('success', 'Thêm mới thành công');
    }
    
    

    public function edit(WorkShift $shift)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('shift'));
    }

     public function update(Request $request,WorkShift $shift)
    {
        $validatedData = $request->validate([
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required|',
            'end_time' => 'required|',
        ]);
        $shift->update($validatedData);
        return redirect()->route('admin.shift.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(WorkShift $shift)
    {
     $shift->delete();
     return redirect()->route('admin.shift.index')->with('success', 'Xóa thành công');
    }
    // GET|HEAD        admin/shift ...................................... admin.shift.index › Admin\ShiftController@index
    // POST            admin/shift ...................................... admin.shift.store › Admin\ShiftController@store
    // GET|HEAD        admin/shift/create ............................. admin.shift.create › Admin\ShiftController@create
    // GET|HEAD        admin/shift/{shift} ................................ admin.shift.show › Admin\ShiftController@show
    // PUT|PATCH       admin/shift/{shift} ............................ admin.shift.update › Admin\ShiftController@update
    // DELETE          admin/shift/{shift} .......................... admin.shift.destroy › Admin\ShiftController@destroy
    // GET|HEAD        admin/shift/{shift}/edit ........................... admin.shift.edit › Admin\ShiftController@edit
}
