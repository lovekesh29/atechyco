@section('sidebar')
<nav id="sidebar" class="sidebar">
    <a class="sidebar-brand" href="index.html">
        <svg>
            <use xlink:href="#ion-ios-pulse-strong"></use>
        </svg>
        Spark
    </a>
    <div class="sidebar-content">
        <div class="sidebar-user">
            <img src="{{ url('img/avatars/avatar.jpg') }}" class="img-fluid rounded-circle mb-2" alt="Linda Miller" />
            <div class="font-weight-bold">Linda Miller</div>
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