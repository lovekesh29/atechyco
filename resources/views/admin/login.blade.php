
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    <link href="{{ url('css/admin.css') }}" rel="stylesheet">

<body>
    <div class="splash active">
		<div class="splash-icon"></div>
	</div>
    <main class="main h-100 w-100">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
    
                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back, Admin</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                        </div>
    
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="{{ url('img/avatars/avatar.jpg') }}" alt="Linda Miller" class="img-fluid rounded-circle" width="132" height="132" />
                                    </div>
                                    <form action="{{ url('admin/login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter your email" required value="{{old('email')}}" />
                                        </div>
                                        @error('email')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
											<div class="alert-message">
												{{$message}}
											</div>

											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
                                        @enderror
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control form-control-lg @error('password') is-invalid @enderror" required type="password" name="password" placeholder="Enter your password" value="{{old('password')}}" />
                                        </div>
                                        @error('password')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
											<div class="alert-message">
												{{$message}}
											</div>

											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
                                        @enderror
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                            <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ url('js/app.js') }}"></script>
	
</body>

</html>