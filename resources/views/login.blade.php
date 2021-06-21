@extends('layouts.app')
@section('home')
<section class="login-section main-page-section">
    <div class="container-fluid login-container">
        <video autoplay muted loop id="myVideo">
            <source src="{{ url('images/login-left.mp4') }}" type="video/mp4">
        </video>
        <div class="row login-div">
            <div class="col-lg-5 login-left">
                <div class="content">
                    <h1>Company Name</h1>
                    <p>Lorem ipsum...</p>
                </div>
            </div>
            <div class="col-lg-6 login-right ">
                <h2 class="text-center">Login Account</h2>
                <p class="text-center">Some Random Text  Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text Some Random Text </p>
                <div class="login-form">
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Email</label>
                            <input type="email" name="email" value="{{old('email')}}"  required class="@error('email') is-invalid @enderror form-control input-left-border"  placeholder="Sam@gmail.com" required>
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
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Password</label>
                            <input type="Password" name="password" value="{{old('password')}}" class="@error('password') is-invalid @enderror form-control input-left-border"  placeholder="password" required>
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
                        </div>
                        <div class="col-lg-12 form-check signup-form-element">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                            />
                            <label class="form-check-label" for="flexCheckDefault">
                              I aggree to tearm & conditions
                            </label>
                            <div class="float-right">
                                <span class="already-sign-in text-center"><a href="{{ url('/forgot-password') }}">Forgot Password</a></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="btn signin-form-btn me-2" type="submit">Sign In</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>

</section>
    
@endsection