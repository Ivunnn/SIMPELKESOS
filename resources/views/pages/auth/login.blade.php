<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SiDesa - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-md-6 ">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 fw-extrabold">Login SIMPELKESOS</h1>
                            <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                        </div>

                        {{-- Alert error kalau login gagal --}}
                        @if($errors->has('loginError'))
                            <div class="alert alert-danger">
                                {{ $errors->first('loginError') }}
                            </div>
                        @endif

                        {{-- Form Login --}}
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="email" class="form-control form-control-user" name="email"
                                    value="{{ old('email') }}" placeholder="Masukkan Email" required autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-user" name="password"
                                    placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </form>


                        {{-- SweetAlert Error --}}
                        @if($errors->has('loginError'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal',
                                    text: '{{ $errors->first('loginError') }}',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Coba Lagi'
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>