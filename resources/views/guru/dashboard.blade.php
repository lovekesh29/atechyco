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
            <div class="col-xl-8 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">My Recent Courses</h5>
                    </div>
                    <div class="card-body popular-course py-3">
                        @foreach ($guruRecentCourses as $guruRecentCourse)
                        <div class="course-card">
                            {!! ($guru->imgPath != null) ? '<img src="'. asset('storage/'.Auth::guard('guru')->user()->imgPath) .'" class="course-img rounded img-fluid" alt="'. $guru->firstName.' '. $guru->lastName .'" />' : '<i class="align-middle fas fa-fw fa-user"></i>' !!} 
                            <div class="course-meta">
                                <h6>{{ $guruRecentCourse->title }}</h6>
                                <span>By: Random Person</span>
                                <br>
                                <span>
                                    <i class="align-middle mr-2 fas fa-fw fa-star"></i>
                                    <i class="align-middle mr-2 fas fa-fw fa-star"></i>
                                    <i class="align-middle mr-2 fas fa-fw fa-star"></i>
                                    <i class="align-middle mr-2 fas fa-fw fa-star"></i>
                                    <i class="align-middle mr-2 fas fa-fw fa-star"></i>
                                    4.5 (2028)
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">UpComing Courses</h5>
                    </div>
                    <div class="card-body popular-course py-3">
                        <div class="upcoming-single">
                            <div class="course-card">
                                <img class="course-img rounded img-fluid" src="{{ url('/img/avatars/avatar-2.jpg') }}" alt="">
                                <div class="course-meta">
                                    <h6>Random Person</h6>
                                    <span>Starts: 17 July</span>
                                </div>
                            </div>
                            <h6>The omplete Graphic Design Theory for Beginners</h6>
                        </div>
                        
                        <div class="upcoming-single">
                            <div class="course-card">
                                <img class="course-img rounded img-fluid" src="{{ url('/img/avatars/avatar-2.jpg') }}" alt="">
                                <div class="course-meta">
                                    <h6>Random Person</h6>
                                    <span>Starts: 17 July</span>
                                </div>
                            </div>
                            <h6>The omplete Graphic Design Theory for Beginners</h6>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="col-xl-4 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row milestone-header">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Courses</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fas fa-fw fa-book-reader"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ count($guruCourseStats) }}</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row milestone-header">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Course Comments</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fas fa-fw fa-book-open"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ array_sum(array_map( 'count', array_column($guruCourseStats, 'get_comments'))) }}</h1>
                                    {{-- <div class="mb-0">
                                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.50% </span> More than usual
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row milestone-header">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Course Likes</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fas fa-fw fa-certificate"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ array_sum(array_map( 'count', array_column($guruCourseStats, 'get_likes'))) }}</h1>
                                    {{-- <div class="mb-0">
                                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 8.35% </span> More than usual
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row milestone-header">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Currently Viewing</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fab fa-fw fa-rocketchat"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ array_sum(array_map( 'count', array_column($guruCourseStats, 'get_current_view'))) }}</h1>
                                    {{-- <div class="mb-0">
                                        <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -4.25% </span> Less than usual
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.user.footer')