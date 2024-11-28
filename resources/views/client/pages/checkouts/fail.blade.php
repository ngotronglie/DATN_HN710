@extends('client.index')
@section('main')
<div class="text-center mx-5">
    <h1>Thanh toán thất bại!</h1>
    <div class="d-flex">
        <a href="{{ route('home') }}" class="">Quay lại trang chủ</a>
        <a href="{{ route('cart.index') }}" class="">Tiếp tục mua hàng</a>
    </div>
</div>
@endsection
