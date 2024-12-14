<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    const PATH_VIEW = 'admin.layout.shift.';

    public function index()
    {
        $shift = WorkShift::with('users')->get();


        return view(self::PATH_VIEW . __FUNCTION__, compact('shift'));
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
            'shift_name.required' => 'Vui lòng nhập tên ca làm việc.',
            'shift_name.max' => 'Tên ca làm việc tối đa 255 kí tự.',
            'shift_name.unique' => 'Tên ca làm việc đã tồn tại.',
            'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
            'start_time.date_format' => 'Thời gian bắt đầu phải đúng định dạng giờ:phút (ví dụ: 08:30).',
            'end_time.required' => 'Thời gian kết thúc là bắt buộc.',
            'end_time.date_format' => 'Thời gian kết thúc phải đúng định dạng giờ:phút (ví dụ: 17:00).'
        ]);

        $exists = WorkShift::where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['end_time' => 'Thời gian bắt đầu và kết thúc đã tồn tại trong hệ thống.'])->withInput();
        }

        $validatedData['start_time'] = $validatedData['start_time'] . ':00';
        $validatedData['end_time'] = $validatedData['end_time'] . ':00';

        WorkShift::create($validatedData);
        return redirect()->route('admin.shift.index')->with('success', 'Thêm mới thành công');
    }



    public function edit(WorkShift $shift)
    {
        $shift->start_time = date('H:i', strtotime($shift->start_time));
        $shift->end_time = date('H:i', strtotime($shift->end_time));
        return view(self::PATH_VIEW . __FUNCTION__, compact('shift'));
    }

    public function update(Request $request, WorkShift $shift)
    {
        $validatedData = $request->validate([
            'shift_name' => [
                'required',
                'string',
                'max:255',
                'unique:work_shifts,shift_name,' . $shift->id
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ], [
            'shift_name.required' => 'Vui lòng nhập tên ca làm việc.',
            'shift_name.max' => 'Tên ca làm việc tối đa 255 kí tự.',
            'shift_name.unique' => 'Tên ca làm việc đã tồn tại.',
            'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
            'start_time.date_format' => 'Thời gian bắt đầu phải đúng định dạng giờ:phút (ví dụ: 08:30).',
            'end_time.required' => 'Thời gian kết thúc là bắt buộc.',
            'end_time.date_format' => 'Thời gian kết thúc phải đúng định dạng giờ:phút (ví dụ: 17:00).'
        ]);
        $validatedData['start_time'] = $validatedData['start_time'] . ':00';
        $validatedData['end_time'] = $validatedData['end_time'] . ':00';
        $shift->update($validatedData);
        return redirect()->route('admin.shift.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(WorkShift $shift)
    {
        $shift->delete();
        return redirect()->route('admin.shift.index')->with('success', 'Xóa thành công');
    }
}
