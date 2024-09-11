<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;

class VoucherController extends Controller
{
    const PATH_VIEW = 'admin.layout.vouchers.';
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $vouchers = Voucher::all();
        return view(self::PATH_VIEW.__FUNCTION__ ,compact('vouchers')); ;
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        
       return  view(self::PATH_VIEW. 'show',compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        // dd($voucher) ;
        return view(self::PATH_VIEW.__FUNCTION__ ,compact('voucher') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        // dd($request) ;
            $voucher->update($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Sửa Vouchers thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}