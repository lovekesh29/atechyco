@extends('layouts.app')
@include('layouts.header')
@section('home')
<section class="signup main-page-section">
    <div class="container section-container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="submit-form">
                    <h2 class="text-center">Regestration Form</h2>
                    <form action="{{ url('/sign-up') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 signup-form-element">
                                <label class="form-label ">First Name</label>
                                <input type="text" required value="{{ old('firstName') }}" name="firstName" class="form-control input-border"  placeholder="Sam" value={{ old('firstName') }}>
                                @error('firstName')
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
                            
                            <div class="col-lg-6 signup-form-element">
                                <label class="form-label ">Last Name</label>
                                <input type="text" required value="{{ old('lastName') }}" name="lastName" class="form-control input-border"  placeholder="Sam">
                                @error('lastName')
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
                           
                        </div>
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Email address</label>
                            <input type="email" required value="{{ old('email') }}" name="email" class="form-control input-border"  placeholder="name@example.com">
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
                        <div class="col-lg-12 signup-form-element">
                            <select class="form-control input-border" name="location" aria-label="Default select example" required>
                                <option selected value="">Select You Country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->countryCode }}">{{ $country->countryName }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        @error('location')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label">Phone</label>
                            <input type="text" id="phone" required value="{{ old('phoneNo') }}" name="phoneNo" class="form-control input-border" >
                            <input type="hidden" id="dialCode" name="dialCode" class="form-control input-border" >
                            <div class="alert alert-danger alert-dismissible" id="phoneErrorLabel" role="alert" style="display: none;">
                                <div class="alert-message">
                                    Invalid Phone No.
                                </div>
                            </div>
                            
                        </div>
                        @error('phoneNo')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label">Password</label>
                            <input type="paswword" required value="{{ old('password') }}" name="password" class="form-control input-border"  placeholder="Enter You Password">
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
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label ">Confirm Password</label>
                            <input type="password" required value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control input-border"  placeholder="name@example.com">
                        </div>
                        @error('password_confirmation')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <select class="form-control input-border" required name="securityQuestion" aria-label="Default select example">
                                <option selected value="">Select You Security Question</option>
                                @foreach ($securityQuestions as $securityQuestion)
                                <option value="{{ $securityQuestion->id }}">{{ $securityQuestion->securityQuestion }}</option>
                                @endforeach
                                
                              </select>
                        </div>
                        @error('securityQuestion')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label">Security Answer</label>
                            <input type="text" required value="{{ old('securityAnswer') }}" name="securityAnswer" class="form-control input-border"  placeholder="Type Security Answer">
                        </div>
                        @error('securityAnswer')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <select class="form-control input-border" required name="gender" aria-label="Default select example">
                                <option selected value="">Select You Gender</option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                                <option value="2">Others</option>
                              </select>
                        </div>
                        @error('gender')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 signup-form-element">
                            <label class="form-label">Age</label>
                            <input type="number" required value="{{ old('age') }}" name="age" class="form-control input-border"  placeholder="Age in Years">
                        </div>
                        @error('age')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                        <div class="col-lg-12 form-check signup-form-element">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value="1"
                              name="termsCondition"
                              id="flexCheckDefault"
                              required
                            />
                            <label class="form-check-label" for="flexCheckDefault">
                              I aggree to tearm & conditions
                            </label>
                        </div>
                        @error('termsCondition')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-message">
                                    {{$message}}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
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