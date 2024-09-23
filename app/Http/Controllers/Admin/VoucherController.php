<?php

namespace App\Http\Controllers\Admin;

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
        $vouchers = Voucher::orderBy('id', 'desc')->get();
        $trashedVouchers = Voucher::onlyTrashed()->count();
        $currentDate = Carbon::now()->startOfDay(); // Đảm bảo rằng bạn so sánh ngày mà không có giờ

        foreach ($vouchers as $voucher) {
            // Chuyển đổi giá trị ngày tháng từ cơ sở dữ liệu thành đối tượng Carbon
            $startDate = Carbon::parse($voucher->start_date)->startOfDay();
            $endDate = Carbon::parse($voucher->end_date)->endOfDay();

            // Xác định trạng thái của voucher
            if ($currentDate->lessThan($startDate) || $currentDate->greaterThan($endDate)) {
                $voucher->is_active = 0; // Không hoạt động nếu hiện tại trước ngày bắt đầu hoặc sau ngày kết thúc
            } else {
                $voucher->is_active = 1; // Hoạt động nếu hiện tại nằm trong khoảng thời gian, bao gồm ngày kết thúc
            }

            // Lưu lại thay đổi vào cơ sở dữ liệu
            $voucher->save();
        }

        return view(self::PATH_VIEW . 'index', compact('vouchers', 'trashedVouchers'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . 'create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $data = $request->all();
        Voucher::create($data);

        return redirect()->route('vouchers.index')->with('success', 'Thêm Voucher thành công');
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
        $data = $request->all();
        $voucher->update($data);

        return redirect()->route('vouchers.index')->with('success', 'Sửa Voucher thành công');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Xóa Voucher thành công');
    }

    public function trashed()
    {
        $vouchers = Voucher::onlyTrashed()->get();
        return view(self::PATH_VIEW . 'trashed', compact('vouchers'));
    }

    public function restore($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();
        return redirect()->route('vouchers.trashed')->with('success', 'Voucher đã được khôi phục');
    }

    public function forceDelete($id)
    {
        $vouchers = Voucher::withTrashed()->findOrFail($id);
        $vouchers->forceDelete();
        return redirect()->route('vouchers.trashed')->with('success', 'Vouchers đã bị xóa vĩnh viễn');
    }
}