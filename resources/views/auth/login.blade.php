@extends('layouts/app')
@section('title', 'Login')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-blod">Login</h2>
                    </div>
                    <div class="card-body p-5">
                        <div id="login_alert"></div>
                        <form action="#s" method="POST" id="login_form">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="email" id="email" class="form-control rounded-0"
                                    placeholder="E-mail">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" id="password" class="form-control rounded-0"
                                    placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <a href="{{ url('forget') }}" class="text-decoration-none">Forget Password</a>
                            </div>
                            <div class="mb-3 d-grid">
                                <input type="submit" class="btn btn-dark rounded-0" value="Login" id="login_btn">
                            </div>
                            <div class="text-center text-scondary">
                                <div>Don't Have an account <a href="{{ url('register') }}"
                                        class="text-decoration-none">Register
                                        Here</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $("#login_form").submit(function(e) {
                e.preventDefault();

                $("#login_btn").val('Please wait...');

                $.ajax({
                    url: "{{ route('auth.login') }}",
                    method: 'post',
                    data: $(this).serialize(),
                    // dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            showError('email', response.message.email)
                            showError('password', response.message.password)
                            $("#login_btn").val('Login');
                        } else if (response.status == 401) {
                            $('#login_alert').html(showMessage('danger', response
                                .message));
                            $("#login_btn").val('Login');

                        } else if (response.status == 200 && response.message == 'success') {
                            window.location = "{{ route('profile') }}";

                        }
                    }
                })




            })
        })
    </script>
@endsection
