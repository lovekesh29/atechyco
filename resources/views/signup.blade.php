@extends('layouts.app')
@include('layouts.header')
@section('home')
<section class="signup main-page-section">
    <div class="container section-container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="submit-form">
                    <h2 class="text-center">Regestration Form</h2>
                    <form action="">
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Name</label>
                            <input type="email" class="form-control input-border"  placeholder="Sam">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Email address</label>
                            <input type="email" class="form-control input-border"  placeholder="name@example.com">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <select class="form-control input-border" aria-label="Default select example">
                                <option selected>Select You Country</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Phone</label>
                            <input type="email" class="form-control input-border"  placeholder="+9199999999">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Password</label>
                            <input type="email" class="form-control input-border"  placeholder="Enter You Password">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <select class="form-control input-border" aria-label="Default select example">
                                <option selected>Select You Security Question</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Security Answer</label>
                            <input type="email" class="form-control input-border"  placeholder="Type Security Answer">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Email address</label>
                            <input type="email" class="form-control input-border"  placeholder="name@example.com">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Gender</label>
                            <input type="email" class="form-control input-border"  placeholder="Male/Female">
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Age</label>
                            <input type="email" class="form-control input-border"  placeholder="Age in Years">
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
                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="btn signup-form-btn me-2" type="submit">Create Account</button>
                        </div>
                        <div class="col-lg-12 text-center">
                            <span class="already-sign-in text-center">Already have an account <a href="{{ url('/login') }}">Sign In</a></span>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@include('layouts.footer')