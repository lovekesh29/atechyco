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
            <small>Front-end Developer</small>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main
            </li>
            <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-home"></i> <span class="align-middle">Dashboards</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/user') ? 'active' : '' }}">
                <a href="{{ url('admin/user') }}" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-user"></i> <span class="align-middle">Users</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/guru') ? 'active' : '' }}">
                <a href="{{ url('admin/guru') }}" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-user"></i> <span class="align-middle">Gurus</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/courses') ? 'active' : '' }}">
                <a href="{{ url('admin/courses') }}" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-book-reader"></i> <span class="align-middle">Courses</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/subscriptions') ? 'active' : '' }}">
                <a href="{{ url('admin/subscriptions') }}" class="sidebar-link">
                    <i class="align-middle mr-2 fas fa-fw fa-money-check"></i> <span class="align-middle">Subscriptions</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
@endsection