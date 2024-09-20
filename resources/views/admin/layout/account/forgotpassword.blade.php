@include('admin.include.head')

<link rel="stylesheet" href="{{ asset('admin/assets/css/cs-skin-elastic.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>

<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="{{ asset('theme/admin/images/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form action="{{route('admin.forgot.password')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            @error('email')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                        </div>
                      
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>


   

</body>
