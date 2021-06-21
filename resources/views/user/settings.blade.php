@extends('layouts.user.app')
@include('layouts.user.sidebar', ['user' => $user])
@include('layouts.user.header', ['user' => $user])
@section('home')
@if (Session::has('success'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('success') }}"
    })
</script>    
@endif
@if (Session::has('error'))
<script>
    swal({
        icon: "error",
        title: 'Error',
        text: "{{ Session::get('error') }}"
    })
</script>    
@endif
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Welcome back, {{ $user->firstName.' '. $user->lastName }}!
            </h1>
            <p class="header-subtitle">You have 24 new messages and 5 new notifications.</p>
        </div>
        <div class="row">
            <div class="col-md-3 col-xl-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#password" role="tab" aria-selected="true">
                            Password
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#pass" role="tab" aria-selected="false">
                            Account
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions float-right">
                                    <a href="#" class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw align-middle"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                    </a>
                                    <div class="d-inline-block dropdown show">
                                        <a href="#" data-toggle="dropdown" data-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Public info</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="inputUsername">Username</label>
                                                <input type="text" class="form-control" id="inputUsername" placeholder="Username">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputUsername">Biography</label>
                                                <textarea rows="2" class="form-control" id="inputBio" placeholder="Tell something about yourself"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="Chris Wood" src="img/avatars/avatar.jpg" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
                                                </div>
                                                <small>For best results, use an image at least 128px by 128px in .jpg
                                                    format</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions float-right">
                                    <a href="#" class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw align-middle"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                    </a>
                                    <div class="d-inline-block dropdown show">
                                        <a href="#" data-toggle="dropdown" data-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Private info</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputFirstName">First name</label>
                                            <input type="text" class="form-control" id="inputFirstName" placeholder="First name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputLastName">Last name</label>
                                            <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Address</label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress2">Address 2</label>
                                        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">State</label>
                                            <select id="inputState" class="form-control">
                                                <option selected="">Choose...</option>
                                                <option>...</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">Zip</label>
                                            <input type="text" class="form-control" id="inputZip">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade active show" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Password</h5>
                                <form action="{{ url('/update-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Current password</label>
                                        <input type="password" required name="currentPassword" value="{{ old('currentPassword') }}" class="@error('currentPassword') is-invalid @enderror form-control">
                                        <small><a href="{{ url('/forgot-password') }}" target="_blank">Forgot your password?</a></small>
                                        @error('currentPassword')
                                        <label class="error small form-text invalid-feedback" style="display: inline-block;">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input type="password" required value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                        <label class="error small form-text invalid-feedback" style="display: inline-block;">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Verify password</label>
                                        <input type="password" required value="{{ old('password_confirmation') }}" name="password_confirmation" class="@error('password_confirmation') is-invalid @enderror form-control">
                                        @error('password_confirmation')
                                        <label class="error small form-text invalid-feedback" style="display: inline-block;">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.user.footer')