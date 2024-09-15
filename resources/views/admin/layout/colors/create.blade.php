@extends('admin.dashboard')


@section('content')
    <div class="content">
        <form action="{{ route(colors . create) }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Tên màu:</label>
                <input type="text" class="form-control" id="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="hex">Mã màu:</label>
                <input type="color" class="form-control" id="hex" value="{{ old(color) }}">
            </div>

            <div class="form-actions form-group">
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
            </div>
        </form>
    </div>
@endsection
