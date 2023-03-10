@extends('layouts.user.app')
@include('layouts.user.sidebar', ['user' => $user])
@include('layouts.user.header', ['user' => $user])
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
        @include('templates.user.dashboardHeader', ['user' => $user])

        <div class="row">
            <div class="col-xl-8 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Popular courses</h5>
                    </div>
                    <div class="card-body popular-course py-3">
                        @foreach ($popularCourses as $popularCourse)
                        <div class="course-card">
                            @if ($popularCourse->author != 0)
                            {!! ($popularCourse->authorName->imgPath != null) ? '<img class="course-img rounded img-fluid" style="width: 80px; height: 80px" src="'. asset('storage/'.$popularCourse->authorName->imgPath) .'" alt="'. $popularCourse->authorName->firstName.' '. $popularCourse->authorName->lastName .'" />' : '<i class="align-middle fas fa-fw fa-user"></i>' !!}
                            @else
                                {!! '<i class="align-middle fas fa-fw fa-user"></i>' !!}
                            @endif
                            
                            <div class="course-meta">
                                <h6> <a href="{{ url('watch-course/'.Crypt::encryptString($popularCourse->id)) }}">{{ $popularCourse->title }}</a> </h6>
                                <span>By: {{ ($popularCourse->author == 0) ? 'Admin' : $popularCourse->authorName->firstName.' '.$popularCourse->authorName->lastName }}</span>
                                <br>
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
                                            <h5 class="card-title">Completed Courses</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fas fa-fw fa-book-reader"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ $completedCourses }}</h1>
                                    <div class="mb-0">
                                        {{-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.65% </span> Less than usual --}}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row milestone-header">
                                        <div class="col mt-0">
                                            <h5 class="card-title">In Progress Courses</h5>
                                        </div>
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle fas fa-fw fa-book-open"></i>
                                                </div>
                                            </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">{{ $inProgressCourses }}</h1>
                                    <div class="mb-0">
                                        {{-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.50% </span> More than usual --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row bottom-section">
            {{-- <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                <div class="card tutor-card flex-fill">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Latest Projects</h5>
                    </div>
                    <table id="datatables-dashboard-projects" class="table table-striped my-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-xl-table-cell">Start Date</th>
                                <th class="d-none d-xl-table-cell">End Date</th>
                                <th>Status</th>
                                <th class="d-none d-md-table-cell">Assignee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Project Apollo</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Carl Jenkins</td>
                            </tr>
                            <tr>
                                <td>Project Fireball</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-danger">Cancelled</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Project Hades</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                            <tr>
                                <td>Project Nitro</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-warning">In progress</span></td>
                                <td class="d-none d-md-table-cell">Carl Jenkins</td>
                            </tr>
                            <tr>
                                <td>Project Phoenix</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Project X</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                            <tr>
                                <td>Project Romeo</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Ashley Briggs</td>
                            </tr>
                            <tr>
                                <td>Project Wombat</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-warning">In progress</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Project Zircon</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-danger">Cancelled</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
            <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                <div class="card tutor-card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Best Gurus</h5>
                    </div>
                    <div class="card-body tutor-body">
                        @foreach ($gurus as $guru)
                        @php
                        // echo "<pre>";
                        // print_r($gurus[0]->imgPath);
                        // die();
                        @endphp
                        <div class="tutor-single d-flex w-100">
                            <div class="tutor-img d-flex w-100">
                                {!! ($guru->imgPath != null) ? '<img src="'. asset('storage/'.$guru->imgPath) .'" class="img-fluid rounded-circle tutor-img" alt="'. $guru->firstName.' '. $guru->lastName .'" />' : '<i class="align-middle fas fa-fw fa-user"></i>' !!}
                                <div class="tutor-meta">
                                    <h6>{{$guru->firstName.' '.$guru->lastName }}</h6>
                                </div>
                            </div>
                            <span>{{$guru->courseCount}} Courses</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@include('layouts.user.footer')