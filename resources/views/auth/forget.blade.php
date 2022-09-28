@extends('layouts/app')
@section('title', 'Forget Password')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-blod">Forget Password</h2>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" id="forget_form">
                            @csrf
                            <div class="mb-3 text-secondary">
                                Enter your e-mail address and we will send you a link for reset your password
                            </div>
                            <div class="mb-3">
                                <input type="text" name="email" id="email" class="form-control rounded-0"
                                    placeholder="E-mail">
                                <div class="invalid-feedback"></div>
                            </div>



                            <div class="mb-3 d-grid">
                                <input type="submit" class="btn btn-dark rounded-0" value="Forget Password"
                                    id="forget_btn">
                            </div>
                            <div class="text-center text-scondary">
                                <div>Back to <a href="{{ url('/') }}" class="text-decoration-none">Login Page</a>
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
            $("#forget_form").submit(function(e) {
                e.preventDefault();
                $("#forget_btn").val("Please Wait...");

                $.ajax({
                    url: "{{ route('auth.forget') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                    }
                })
            })
        })
    </script>
@endsection
