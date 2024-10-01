@extends('client.index')

@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section mb-5">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Register</h1>
                    <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li class="active">Register</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <div class="register-wrapper container  ">

        <!-- Login Title & Content Start -->
        <div class="section-content text-center mb-5">
            <h2 class="title mb-2">Create Account</h2>
            <p class="desc-content">Please Register using account detail bellow.</p>
        </div>
        <!-- Login Title & Content End -->

        <!-- Form Action Start -->
        <form action="{{ route('register') }}" method="post">
            @csrf

            <!-- Input Last Name Start -->
            <div class="single-input-item mb-3">
                <input type="text" placeholder=" User Name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <!-- Input Last Name End -->

            <!-- Input Email Or Username Start -->
            <div class="single-input-item mb-3">
                <input type="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <!-- Input Email Or Username End -->

            <!-- Input Password Start -->
            <div class="single-input-item mb-3">
                <input type="password" name="password" placeholder="Enter your Password" value="{{ old('password') }}">
                @error('password')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <!-- Input Password End -->

            <!-- Register Button Start -->
            <div class="single-input-item mb-3">
                <button class="btn btn btn-dark btn-hover-primary rounded-0">Register</button>
            </div>
            <!-- Register Button End -->

        </form>
        <!-- Form Action End -->
        <div class="h6 text-center">
            Login -> <a href="/login">click here</a>
        </div>

    </div>
@endsection
