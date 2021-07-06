<div class="header">
    <h1 class="header-title">
        Welcome back, {{ $guru->firstName.' '. $guru->lastName }}!
    </h1>
    <p class="header-subtitle">You have 24 new messages and 5 new notifications.</p>
    @if(Auth::guard('guru')->user()->phoneVerified != '1')
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div class="alert-message">
            <strong>Hello {{ $guru->firstName.' '. $guru->lastName }}</strong> Your Phone No. is not verified. Verify it now by  <a href="{{ url('guru/user-phone-verification') }}">clicking here</a> 
        </div>
    </div>
    @endif
</div>