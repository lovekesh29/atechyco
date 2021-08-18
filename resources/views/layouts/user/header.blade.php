@section('header')
@php
    $walletCredit = App\Models\UserWallet::where('userId', Auth::id())->sum('creditPoints');
@endphp
<nav class="navbar navbar-expand navbar-theme">
    <a class="sidebar-toggle d-flex mr-2">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown ml-lg-2">
                <a class="nav-link dropdown-toggle position-relative" href="#">
                    <i class="align-middle fas fa-fw fa-wallet" data-count="{{ $walletCredit }}"></i>
                </a>
            </li>
            <li class="nav-item dropdown ml-lg-2">
                <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-toggle="dropdown">
                    <i class="align-middle fas fa-cog"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ url('view-profile') }}"><i class="align-middle mr-1 fas fa-fw fa-user"></i> View Profile</a>
                    <a class="dropdown-item" href="{{ url('/user-settings') }}"><i class="align-middle mr-1 fas fa-fw fa-cogs"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}"><i class="align-middle mr-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                </div>
            </li>
        </ul>
    </div>

</nav>
@endsection