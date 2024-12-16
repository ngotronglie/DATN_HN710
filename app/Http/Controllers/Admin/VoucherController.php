<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class VoucherController extends Controller
{
    const PATH_VIEW = 'admin.layout.vouchers.';

    public function index()
    {
        if (Gate::denies('viewAny', Voucher::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $vouchers = Voucher::orderBy('id', 'desc')->get();

        return view(self::PATH_VIEW . 'index', compact('vouchers'));
    }

    public function create()
    {
        if (Gate::denies('create', Voucher::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . 'create');
    }

    public function store(StoreVoucherRequest $request)
    {
        if (Gate::denies('create', Voucher::class)) {
            return redirect()->route('admin.vouchers.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $startDate = Carbon::parse($data['start_date']);
        $data['is_active'] = $startDate->isFuture() ? 0 : 1;
        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm Voucher thành công');
    }

    public function show(Voucher $voucher)
    {
        if (Gate::denies('view', $voucher)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . 'show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        if (Gate::denies('update', $voucher)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }
        return view(self::PATH_VIEW . 'edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        if (Gate::denies('update', $voucher)) {
            return redirect()->route('admin.vouchers.index')->with('warning', 'Bạn không có quyền!');
        }
        $data = $request->all();
        $startDate = Carbon::parse($data['start_date']);
        $data['is_active'] = $startDate->isFuture() ? 0 : 1;
        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Sửa Voucher thành công');
    }
}
