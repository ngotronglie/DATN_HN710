<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use Carbon\Carbon;

class VoucherController extends Controller
{
    const PATH_VIEW = 'admin.layout.vouchers.';

    public function index()
    {
        $vouchers = Voucher::all();

        return view(self::PATH_VIEW . 'index', compact('vouchers'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . 'create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $data = $request->validated();
        Voucher::create($data);

        return redirect()->route('vouchers.index')->with('success', 'Thêm Voucher thành công!');
    }

    public function show(Voucher $voucher)
    {
        return view(self::PATH_VIEW . 'show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view(self::PATH_VIEW . 'edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $data = $request->validated();

        // Xác định trạng thái hoạt động dựa trên ngày hiện tại
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $isActive = $startDate->lessThanOrEqualTo(Carbon::now()) && $endDate->greaterThanOrEqualTo(Carbon::now());

        // Cập nhật voucher với dữ liệu mới và trạng thái hoạt động
        $voucher->update(array_merge($data, ['is_active' => $isActive]));

        return redirect()->route('vouchers.index')->with('success', 'Sửa Voucher thành công!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Xóa Voucher thành công!');
    }
}