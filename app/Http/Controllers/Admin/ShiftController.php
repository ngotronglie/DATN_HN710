<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class ShiftController extends Controller
{
    const PATH_VIEW = 'admin.layout.shift.';

    public function index()
    {
        $shift = WorkShift::all();

        return view(self::PATH_VIEW . __FUNCTION__,compact('shift'));
    }

    public function create()
    {

    }

    public function store(Request $request,WorkShift $workShift)
    {

    }

    public function edit(WorkShift $workShift)
    {

    }

     public function update(Request $request,WorkShift $workShift)
    {

    }

    public function destroy()
    {

    }
    // GET|HEAD        admin/shift ...................................... admin.shift.index › Admin\ShiftController@index
    // POST            admin/shift ...................................... admin.shift.store › Admin\ShiftController@store
    // GET|HEAD        admin/shift/create ............................. admin.shift.create › Admin\ShiftController@create
    // GET|HEAD        admin/shift/{shift} ................................ admin.shift.show › Admin\ShiftController@show
    // PUT|PATCH       admin/shift/{shift} ............................ admin.shift.update › Admin\ShiftController@update
    // DELETE          admin/shift/{shift} .......................... admin.shift.destroy › Admin\ShiftController@destroy
    // GET|HEAD        admin/shift/{shift}/edit ........................... admin.shift.edit › Admin\ShiftController@edit
}
