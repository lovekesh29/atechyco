@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
@if (Session::has('status'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('status') }}"
    })
</script>    
@endif
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Edit User
            </h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User Details</h5>
                    </div>
                    <div class="card-body">
                        @error('dialCode')
                        <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                        @enderror
                        @error('userId')
                        <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                        @enderror
                        <form action="{{ url('/admin/edit-user') }}" method="POST" id="adminEditUserForm">
                            @csrf
                            <input type="hidden" name="userId" value="{{ Crypt::encryptString($userDetails->id) }}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >First Name</label>
                                    <input type="text" name="firstName" required value="{{ $userDetails->firstName }}" class="@error('firstName') is-invalid @enderror form-control" placeholder="First Name">
                                    @error('firstName')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Last Name</label>
                                    <input type="text" name="lastName" required value="{{ $userDetails->lastName }}" class="@error('lastName') is-invalid @enderror form-control"  placeholder="Last Name">
                                    @error('lastName')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Phone No</label>
                                    <input type="text" required id="adminPhone" value="{{ $userDetails->phoneNo }}" name="phoneNo" class="@error('fullPhoneNo')  is-invalid @enderror form-control">
                                    <input type="hidden" id="dialCode" name="dialCode" class="form-control input-border">

                                    <label class="error form-text invalid-feedback" id="phoneErrorLabel" style="display: none;">Invalid Phone No.</label>

                                    @error('fullPhoneNo')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Age</label>
                                    <input type="text" name="age" required value="{{ $userDetails->age }}" class="@error('age') is-invalid @enderror form-control"  placeholder="Age">
                                    @error('age')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Gender</label>
                                    <select class="@error('gender') is-invalid @enderror form-control input-border" name="gender" required aria-label="Default select example">
                                        <option selected value="{{ $userDetails->gender }}">{{ config('custom.gender.'.$userDetails->gender) }}</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Others</option>
                                      </select>
                                    @error('gender')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Location</label>
                                    <select required name="location" class="form-control mb-3 @error('location') is-invalid @enderror">
										<option selected="" value="{{ $userDetails->location }}">{{ $userDetails->country->countryName }}</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->countryCode }}">{{ $country->countryName }}</option>
                                        @endforeach
									</select>
                                    @error('location')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Email</label>
                                    <input type="email" name="email" required value="{{ $userDetails->email }}" class="@error('email') is-invalid @enderror form-control" placeholder="Email" readonly>
                                    @error('email')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Security Question</label>
                                    <select class="@error('securityQuestion') is-invalid @enderror form-control input-border" name="securityQuestion" required aria-label="Default select example">
                                        <option selected value="{{ $userDetails->securityQuestion }}">{{ $userDetails->securityQuestionDetail->securityQuestion }}</option>
                                        @foreach ($securityQuestions as $securityQuestion)
                                        <option value="{{ $securityQuestion->id}}">{{ $securityQuestion->securityQuestion }}</option>
                                        @endforeach
                                      </select>
                                      @error('securityQuestion')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Security Answer</label>
                                    <input type="text" name="securityAnswer" required value="{{ $userDetails->securityAnswer }}" class="@error('securityAnswer') is-invalid @enderror form-control"  placeholder="Security Answer">
                                    @error('securityAnswer')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="adminEditUserFormButton" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection