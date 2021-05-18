@extends('layouts.app')
@section('home')
<section class="login-section main-page-section">
    <div class="container-fluid login-container">
        <video autoplay muted loop id="myVideo">
            <source src="images/login-left.mp4" type="video/mp4">
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
                    <form action="">
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Email</label>
                            <input type="email" class="form-control input-left-border"  placeholder="Sam">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Password</label>
                            <input type="Password" class="form-control input-left-border"  placeholder="name@example.com">
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
                                <span class="already-sign-in text-center"><a href="">Sign In</a></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="btn signin-form-btn me-2" type="submit">Create Account</button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>

</section>
    
@endsection