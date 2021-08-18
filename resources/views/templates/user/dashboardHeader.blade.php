<div class="header">
    <h1 class="header-title">
        Welcome back, {{ $user->firstName.' '. $user->lastName }}!
    </h1>
    @if(Auth::user()->phoneVerified != '1')
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div class="alert-message">
            <strong>Hello {{ $user->firstName.' '. $user->lastName }}</strong> Your Phone No. is not verified. Verify it now by  <a href="{{ url('/user-phone-verification') }}">clicking here</a> 
        </div>
    </div>
    @endif
</div>