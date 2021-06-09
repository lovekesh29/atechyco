@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
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
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >First Name</label>
                                    <input type="text" value="{{ $userDetails->firstName }}" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Last Name</label>
                                    <input type="text" value="{{ $userDetails->lastName }}" class="form-control"  placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Phone No</label>
                                    <input type="text" value="{{ $userDetails->phoneNo }}" class="form-control" placeholder="Phone No.">
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Age</label>
                                    <input type="text" value="{{ $userDetails->age }}" class="form-control"  placeholder="Age">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Gender</label>
                                    <select class="form-control input-border" aria-label="Default select example">
                                        <option selected value="{{ $userDetails->gender }}">{{ config('custom.gender.'.$userDetails->gender) }}</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Others</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Location</label>
                                    <input type="text" value="{{ $userDetails->location }}" class="form-control"  placeholder="Password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" value="{{ $userDetails->email }}" class="form-control" id="inputEmail4" placeholder="Email" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Security Question</label>
                                    <select class="form-control input-border" aria-label="Default select example">
                                        <option selected value="{{ $userDetails->securityQuestion }}">{{ $userDetails->securityQuestionDetail->securityQuestion }}</option>
                                        @foreach ($securityQuestions as $securityQuestion)
                                        <option value="{{ $securityQuestion->id}}">{{ $securityQuestion->securityQuestion }}</option>
                                        @endforeach
                                      </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label >Security Answer</label>
                                    <input type="text" value="{{ $userDetails->securityAnswer }}" class="form-control"  placeholder="Security Answer">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection