@extends('client.index')

@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light mb-5">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Login</h1>
                    <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li class="active">Login</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <div class="register-wrapper container mt-5 ">


        <!-- Form Action Start -->
        <form action="{{ route('login') }}" method="post">
            @csrf
            <!-- Input Email Or Username Start -->
            <div class="single-input-item mb-3">
                <input type="email" name="email" placeholder="Enter or Email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-center mt-2 bg-danger text-light">{{ $message }}</div>
                @enderror

            </div>
            <!-- Input Email Or Username End -->

            <!-- Input Password Start -->
            <div class="single-input-item mb-3">
                <input type="password" name="password" placeholder="Enter your Password" value="{{ old('password') }}">
                @error('password')
                    <div class="text-center mt-2 bg-danger text-light">{{ $message }}</div>
                @enderror
            </div>
            <!-- Input Password End -->

            <!-- Login Button Start -->
            <div class="single-input-item mb-3">
                <button class="btn btn btn-dark btn-hover-primary rounded-0">Login</button>
            </div>
            <!-- Login Button End -->

        </form>
        <!-- Form Action End -->
        <div class="h6 text-center">
            Register -> <a href="/register">click here</a>
        </div>

    </div>
@endsection
