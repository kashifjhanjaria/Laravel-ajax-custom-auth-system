@extends('layouts.app')

@section('title', 'Profile')
@section('content')


    <div class="container">
        <div class="ro my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="tex-scondary fw-bold">{{ $user->name }}</h2>
                        <a href="{{ route('auth.logout') }}" class="btn btn-dark">Logout</a>
                    </div>
                    <div class="card-body p-5">
                        <div id="profile_alert"></div>
                        <div class="row">
                            <div class="col-lg-4 px-4 text-center" style="border-right:1px solid #999">
                                @if ($user->picture)
                                    <img src="storage/images/{{ $user->picture }}" id="image_preview"
                                        class="img-fluid rounded-circle img-thumbnail" width="200px">
                                @else
                                    <img src="{{ asset('image/profile.jpeg') }}" id="image_preview"
                                        class="img-fluid rounded-circle img-thumbnail" width="200px">
                                @endif

                                <div>

                                    <label for="picture"> Change Profile Picture</label>
                                    <input type="file" name="picture" id="picture" class="form-control rounded-pill">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                            <div class="col-lg-8 px-5">
                                <form action="" method="POST" id="profile_form">
                                    @csrf
                                    <div class="my-2">
                                        <label for="name">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control rounded-0"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="my-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" name="email" id="email" class="form-control rounded-0"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-select rounded-0">
                                                <option value="" selected disabled>-Select-</option>
                                                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" name="dob" id=""
                                                class="form-control rounded-0" value="{{ $user->dob }}">
                                        </div>

                                    </div>
                                    <div class="my-2">
                                        <label for="phone">Phone</label>
                                        <input type="tel" name="phone" id="phone" class="form-control"
                                            value="{{ $user->phone }}">
                                    </div>
                                    <div class="my-2">
                                        <input type="submit" value="Update Profile"
                                            class="btn btn-primary rounded-0 float-end" id="profile_btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(function() {
            $('#picture').change(function(e) {
                const file = e.target.files[0];
                let url = window.URL.createObjectURL(file);
                $("#image_preview").attr('src', url);
                let fd = new FormData();
                fd.append('picture', file);
                fd.append('user_id', $('#user_id').val());
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ route('profile.image') }}",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            $("#profile_alert").html(showMessage('success', response.message));
                            $('#picture').val('');
                        }
                    }
                })
            })


            $('#profile_form').submit(function(e) {
                e.preventDefault();
                let user_id = $('#user_id').val();
                console.log(user_id);
                $('#profile_btn').val('Updating...');

                $.ajax({
                    url: "{{ route('profile.update') }}",
                    method: "POST",
                    data: $(this).serialize() + `&id=${user_id}`,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            $("#profile_alert").html(showMessage('success', response.message));
                            $('#profile_btn').val('Update Profile');



                        }
                    }
                })
            })



        });
    </script>

@endsection
