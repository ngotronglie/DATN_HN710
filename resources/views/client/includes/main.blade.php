@extends('client.index')

@section('main')
    <!-- Hero/Intro Slider Start -->
    @include('client.includes.banner')
    <!-- Hero/Intro Slider End -->

    <!-- Banner Section Start -->
    @include('client.includes.banner2')
    <!-- Banner Section End -->

    <!-- Feature Section Start -->
    @include('client.includes.feature')
    <!-- Feature Section End -->

    <!-- Product Section Start -->
    @include('client.includes.product')
    <!-- Product Section End -->

    <!-- Banner Fullwidth Start -->
    @include('client.includes.banner-fullwidth')
    <!-- Banner Fullwidth End -->

    <!-- Banner Section Start -->
    @include('client.includes.banner3')
    <!-- Banner Section End -->

    <!-- Brand Logo Start -->
    @include('client.includes.brand')
    <!-- Brand Logo End -->
@endsection
