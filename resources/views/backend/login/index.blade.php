<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login | App</title>
    <!-- MDB icon -->
    <link rel="icon" href="{{ asset('/backend/assets/images/logo/favicon.svg') }}" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('/backend/login/css/bootstrap-login-form.min.css') }}" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <link rel="stylesheet" href="sweetalert2.min.css"> --}}
</head>

<body>
    <!-- Start your project here-->

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="{{ asset('/backend/login/img/draw2.svg') }}" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <!-- text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="username" name="username"
                                class="form-control form-control-lg @error('username') is-invalid @enderror" />
                            <label class="form-label" for="username">Username</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg  @error('password') is-invalid @enderror" />
                            <label class="form-label" for="password">Password</label>
                        </div>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <div class="d-flex justify-content-around align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3"
                                    checked />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div> --}}

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                        {{-- <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
                        </div>

                        <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
                            role="button">
                            <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
                        </a>
                        <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!" 
                        role="button">
                        <i class="fab fa-twitter me-2"></i>Continue with Twitter</a> --}}

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('/backend/login/js/mdb.min.js') }}"></script>
    <!-- Custom scripts -->
    <script type="{{ asset('/backend/login/text/javascript') }}"></script>
    {{-- <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script> --}}

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                // position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="">Why do I have this issue?</a>'
            })
        </script>
    @endif
</body>

</html>
