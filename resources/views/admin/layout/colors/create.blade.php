@extends('admin.dashboard')

@section('content')
    <div class="content">
        <form action="{{ route('color.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Tên màu:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="hex_code">Mã màu:</label>
                <input type="color" class="form-control @error('hex_code') is-invalid @enderror" id="hex"
                    name="hex_code" value="{{ old('hex_code') }}">
                @error('hex_code')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions form-group">
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
            </div>
        </form>
    </div>
@endsection
