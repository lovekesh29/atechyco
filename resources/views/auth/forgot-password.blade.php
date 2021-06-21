@extends('layouts.app')
@include('layouts.header')
@section('home')
<div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 offset-md-4">
            <div class="forgot-password-pannel panel panel-default">
              <div class="forgot-pannel-body panel-body">
                <div class="text-center">
                  <h3 class="lock-icon-forgot"><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Forgot Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
    
                    <form class="form" action="{{ $action }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                            <input name="email" placeholder="Enter Your email address" class="@error('email') is-invalid @enderror form-control"  type="email">
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
                        </div>
                        <div class="form-group">
                            <input class="btn btn-lg btn-primary btn-block" type="submit">
                        </div>
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>
@endsection
@section('scripts')
@if (Session::has('status'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('status') }}"
    });
</script>    
@endif
@endsection
@include('layouts.footer')