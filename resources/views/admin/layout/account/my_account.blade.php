@extends('admin.dashboard')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="content" style="width: 100%; max-width: 600px;">
            <div class="animated fadeIn">
                <div class="row" style="justify-content: center;">
                    <div class="col-lg-12">
                        <div class="card" style="width: 100%;">
                            <div class="card-header">Thông Tin Cá Nhân</div>
                            <div class="card-body card-block">

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input type="text" id="username" name="username" placeholder="Username"
                                            class="form-control" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                        <input type="email" id="email" name="email" placeholder="Email"
                                            class="form-control" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                                        <input type="text" id="address" name="address" placeholder="Address"
                                            class="form-control" value="{{ $user->address }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                        <input type="text" id="phone" name="phone" placeholder="Phone"
                                            class="form-control" value="{{ $user->phone }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                            placeholder="Date_of_birth" class="form-control"
                                            value="{{ $user->date_of_birth }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group ">

                                        <img width="100px" src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                            class="ml-auto mr-auto">
                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/init/datatables-init.js') }}"></script>

    <script src="{{ asset('plugins/js/checkall.js') }}"></script>

    <script src="{{ asset('plugins/js/changeActive/Account/changeActiveAccount.js') }}"></script>

    <script src="{{ asset('plugins/js/changeActive/Account/changeAllActiveAccount.js') }}"></script>
@endsection
