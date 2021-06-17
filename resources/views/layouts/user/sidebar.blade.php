@section('sidebar')
<nav id="sidebar" class="sidebar">
    <a class="sidebar-brand" href="index.html">
        <svg>
            <use xlink:href="#ion-ios-pulse-strong"></use>
        </svg>
        Atechyco
    </a>
    <div class="sidebar-content">
        <div class="sidebar-user">
            {!! ($user->imgPath != null) ? '<img src="'. asset('storage/'.Auth::user()->imgPath) .'" class="img-fluid rounded-circle mb-2" alt="'. $user->firstName.' '. $user->lastName .'" />' : '<i class="align-middle fas fa-fw fa-user"></i>' !!}
            <div class="font-weight-bold">{{ $user->firstName.' '. $user->lastName }}</div>
            <small>Html Student</small>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main
            </li>
            <li class="sidebar-item active">
                <a href="#dashboards" data-toggle="collapse" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-home"></i> <span class="align-middle">Dashboards</span>
                </a>
                {{-- <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse show" data-parent="#sidebar">
                    <li class="sidebar-item active"><a class="sidebar-link" href="dashboard-default.html">Default</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="dashboard-analytics.html">Analytics</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="dashboard-e-commerce.html">E-commerce</a></li>
                </ul> --}}
            </li>
        </ul>
    </div>
</nav>
    
@endsection