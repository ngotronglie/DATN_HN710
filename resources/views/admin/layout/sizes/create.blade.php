@extends('admin.dashboard')

@section('content')
    <div class="content">
        <form action="{{ route('size.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Tên kích cỡ:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-actions form-group">
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
            </div>
        </form>
    </div>
@endsection
