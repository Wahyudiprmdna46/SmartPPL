<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Smart-PPL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('halaman_auth/images/icons/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('halaman_auth/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('halaman_auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('halaman_auth/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('halaman_auth/css/main.css') }}">
</head>

<body style="background-color: #666666;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form action="{{ route('admin.login') }}" method="POST" class="login100-form validate-form">
                    @csrf
                    <a href="/" class="btn btn-sm btn-primary">Kembali</a>
                    <span class="login100-form-title p-b-43">Login to continue</span>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate="Masukkan Email, NIM, NIP, atau NPSN">
                        <input class="input100" type="text" name="login" value="{{ old('login') }}" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">NIM / NIP / NPSN</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <div class="flex-sb-m p-t-3 p-b-32 w-full">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                            <label class="label-checkbox100" for="ckb1">Remember me</label>
                        </div>
                        {{-- <div>
                            <a href="#" class="txt1">Forgot Password?</a>
                        </div> --}}
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">Login</button>
                    </div>
                </form>

                <div class="login100-more"
                    style="background-image: url('{{ asset('halaman_auth/images/bg-02.jpg') }}');"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('halaman_auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('halaman_auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('halaman_auth/js/main.js') }}"></script>
</body>

</html>
