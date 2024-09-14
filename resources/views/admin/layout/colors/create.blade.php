@extends('admin.dashboard')


@section('content')
    <div class="content">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">Thêm color</div>
                <div class="card-body card-block">
                    <div class="form-group"><label for="company" class=" form-control-label">Company</label><input
                            type="text" id="company" placeholder="Enter your company name" class="form-control"></div>
                    <div class="form-group"><label for="vat" class=" form-control-label">VAT</label><input
                            type="text" id="vat" placeholder="DE1234567890" class="form-control"></div>
                    <div class="form-group"><label for="street" class=" form-control-label">Street</label><input
                            type="text" id="street" placeholder="Enter street name" class="form-control"></div>
                    <div class="row form-group">
                    </div>
                    <div class="form-group"><label for="country" class=" form-control-label">Country</label><input
                            type="text" id="country" placeholder="Country name" class="form-control"></div>
                </div>
            </div>
        </form>
    </div>
@endsection
