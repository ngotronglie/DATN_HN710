<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
    $query = Order::with(['user', 'voucher', 'orderDetails.productVariant.product'])
                    ->orderBy('status', 'asc');

    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $order = $query->get();
    $statusCounts = [
        'all'=>Order::all()->count(),
        'pending' => Order::where('status', 1)->count(),
        'processing' => Order::where('status', 2)->count(),
        'shipping' => Order::where('status', 3)->count(),
        'completed' => Order::where('status', 4)->count(),
        'pending_cancel' => Order::where('status', 5)->count(),
        'canceled' => Order::where('status', 6)->count(),
    ];
    return view('admin.layout.order.index', compact('order','statusCounts'));
}

    public function detail($order_id){

        $order = Order::with(['orderDetails.productVariant.product','orderDetails.productVariant.size','orderDetails.productVariant.color','user'])->findOrFail($order_id);
        return view('admin.layout.order.detail', compact('order'));
    }
   
    public function confirmOrder($order_id){
        $order = Order::find($order_id);

        if ($order->status == 1) { 
            $order->status = 2; 
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận đơn hàng với trạng thái hiện tại');
        }
    }

    public function shipOrder($order_id){
        $order = Order::find($order_id);

        if ($order->status == 2) {
            $order->status = 3; 
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đang được giao');
        } else {
            return redirect()->back()->with('error', 'Không thể giao hàng với trạng thái hiện tại');
        }
    }

    public function confirmShipping($order_id){
        $order = Order::find($order_id);

        if ($order->status == 3) { 
            $order->status = 4; 
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được giao thành công');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận giao hàng với trạng thái hiện tại');
        }
    }

    public function cancelOrder($order_id){
        $order = Order::find($order_id);

        if ($order->status == 5) { 
            $order->status = 6;
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã bị hủy');
        } else {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng với trạng thái hiện tại');
        }
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
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
