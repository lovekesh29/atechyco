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
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Zip</label>
                                    <input type="text" class="form-control" id="inputZip">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-label">Check me out</span>
                                </label>
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