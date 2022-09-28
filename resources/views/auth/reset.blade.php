@extends('layouts/app')
@section('title', 'Reset Password')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="fw-blod">Reset Password'</h2>
                    </div>
                    <div class="card-body p-5">
                        <form action="#s" method="POST" id="reset_form">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="email" id="email" class="form-control rounded-0"
                                    placeholder="E-mail">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="npassword" id="npassword" class="form-control rounded-0"
                                    placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="cnpassword" id="cnpassword" class="form-control rounded-0"
                                    placeholder="Confirm Password">
                                <div class="invalid-feedback"></div>
                            </div>


                            <div class="mb-3 d-grid">
                                <input type="submit" class="btn btn-dark rounded-0" value="Update Password" id="reset_btn">
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
