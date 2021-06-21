@extends('layouts.app')
@include('layouts.header')
@section('home')
<section class="reset-password main-page-section">
<div class="container section-container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="submit-form">
                <h2 class="text-center">Reset Password</h2>
                <form action="{{ $action }}" method="POST">
                    @csrf
                    <div class="col-lg-12 signup-form-element">
                        <label class="form-label ">Email address</label>
                        <input type="email" readonly required name="email" value="{{ $email }}" class="form-control input-border"  >
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
                        <input type="hidden" name="token" value="{{ $token }}">
                    <div class="col-lg-12 text-center">
                        <button class="btn signup-form-btn me-2" type="submit">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('scripts')
@if (Session::has('status'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('status') }}"
    })
</script>    
@endif
@endsection
@include('layouts.footer')