@php
    $user = Auth::user();
@endphp
@extends('layouts.user.app')
@include('layouts.user.sidebar', ['user' => $user])
@include('layouts.user.header', ['user' => $user])
@section('home')
@php
    //dd(Session::all());
@endphp
@if (Session::has('Error'))
<script>
    swal({
        icon: "error",
        title: 'Error',
        text: "{{ Session::get('Error') }}"
    })
</script>    
@endif

@if(Session::has('sessionId'))
<main class="content">
    <div class="container-fluid">

        @include('templates.user.dashboardHeader', ['user' => $user])
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Phone Verification</h5>
                    </div>
                    <div class="card-body">
                        @error('sessionId')
                            <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                        @enderror
                        <form action="{{ url('verify-user-phone') }}" method="POST">
                            @csrf
                            <input type="hidden" name="sessionId" value="{{ Session::get('sessionId') }}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Otp</label>
                                    <input type="number" name="otp" required class="@error('otp') is-invalid @enderror form-control">
                                    @error('otp')
                                    <label class="error form-text invalid-feedback" for="validation-email">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Verify OTP</button>
                        </form>
                        <label> <a href="{{ url('/user-phone-verification') }}">Resent OTP</a></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@else
    @php
        abort(419);
    @endphp
@endif
@endsection
@include('layouts.user.footer')