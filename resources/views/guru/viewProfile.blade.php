@extends('layouts.guru.app')
@include('layouts.guru.sidebar', ['guru' => $guru])
@include('layouts.guru.header', ['guru' => $guru])
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

        @include('templates.guru.dashboardHeader', ['guru' => $guru])
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Basic form</h5>
                        <h6 class="card-subtitle text-muted">Default Bootstrap form layout.</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('guru/update') }}" method="POST" enctype="multipart/form-data" id="updateguruForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>First Name</label>
                                    <input type="text" name="firstName" value="{{ $guru->firstName }}" required class="@error('firstName') is-invalid @enderror form-control">
                                    @error('firstName')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name</label>
                                    <input type="text" name="lastName" value="{{ $guru->lastName }}" required class="@error('lastName') is-invalid @enderror form-control">
                                    @error('lastName')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" readonly name="email" value="{{ $guru->email }}" required class="@error('email') is-invalid @enderror form-control" placeholder="Email">
                                    @error('email')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone No.</label>
                                    <input type="phone" name="phoneNo" value="{{ $guru->phoneNo }}" id="guruPhone" required class="@error('fullPhoneNo') is-invalid @enderror form-control">
                                    <input type="hidden" id="dialCode" name="dialCode" class="form-control input-border">
                                    
                                    <label class="error form-text invalid-feedback" id="phoneErrorLabel">Invalid Phone No.</label>

                                    @error('fullPhoneNo')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="form-label w-100">Select You Profile Image</label>
                                    <input name="profileImg" type="file" class="@error('profileImg') is-invalid @enderror" @if($guru->imgPath == null) required @endif>
                                    <small class="form-text text-muted">Max 5Mb</small>
                                    @error('profileImg')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Location</label>
                                    <select required name="location" class="form-control mb-3 @error('location') is-invalid @enderror">
										<option selected="" value="{{ $countryName->countryCode }}">{{ $countryName->countryName }}</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->countryCode }}">{{ $country->countryName }}</option>
                                        @endforeach
									</select>
                                    @error('location')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="updateguruFormButton" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.guru.footer')