@extends('layouts/app')
@section('title', 'Register')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-blod">Register</h2>
                    </div>
                    <div class="card-body p-5">
                        <div id="show_success_alert"></div>
                        <form action="#" method="POST" id="register_form">
                            @csrf

                            <div class="mb-3">
                                <input type="text" name="name" id="name" class="form-control rounded-0"
                                    placeholder="Full Name">
                                <div class="invalid-feedback"></div>
                            </div>




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
                                <input type="password" name="cpassword" id="cpassword" class="form-control rounded-0"
                                    placeholder="Confirm Password">
                                <div class="invalid-feedback"></div>
                            </div>


                            <div class="mb-3 d-grid">
                                <input type="submit" class="btn btn-dark rounded-0" value="Register" id="register_btn">
                            </div>
                            <div class="text-center text-scondary">
                                <div>Already Have an account <a href="{{ url('/') }}"
                                        class="text-decoration-none">Login
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
            $('#register_form').submit(function(e) {
                e.preventDefault();
                $('#register_btn').val('Please wait....');
                $.ajax({
                    url: '{{ route('auth.register') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            showError('name', response.message.name)
                            showError('email', response.message.email)
                            showError('password', response.message.password)
                            showError('cpassword', response.message.cpassword)
                            $("#register_btn").val('Register');
                        } else if (response.status == 200) {
                            $("#show_success_alert").html(showMessage('success', response
                                .message));
                            $('#register_form')[0].reset();
                            removeValidationClasses("#register_form");
                            $("#register_btn").val('Register');
                        }
                    }
                });
            });
        });
    </script>
@endsection
