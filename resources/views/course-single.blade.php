@extends('layouts.app')
@include('layouts.header')
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
    <section class="course-banner d-flex">
            <div class="container">
                <div class="row"> 
                    <div class="col-lg-12 col-sm-12 align-items-center d-flex justify-content-center course-banner-row">
                        <div class="banner-content course-banner-content">
                            <h1>{{ $courseDetails->title }}</h1>
                        </div>
                    </div>
                </div>
                
            </div>
    </section>
    <section class="course-description main-page-section">
        <div class="container section-container">
            <div class="pt-lg-12 pb-lg-12 py-6 ">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12 mb-8">
                        <div>
                            <ul class="nav-pills-border nav nav-pills nav-justified mb-5 " id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold active" id="pills-Overview-tab" data-toggle="pill" href="#pills-Overview" role="tab" aria-controls="pills-Overview" aria-selected="true">Overview</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link font-weight-bold " id="pills-Curriculum-tab" data-toggle="pill" href="#pills-Curriculum" role="tab" aria-controls="pills-Curriculum" >Curriculum</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="pills-Overview" role="tabpanel" aria-labelledby="pills-Overview-tab">
                                <div>
                                    {!! $courseDetails->description !!}
                                    <a href="{{ url('/watch-course/'.Crypt::encryptString($courseDetails->id)) }}" class="btn btn-warning" target="_blank">Watch Now</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-Curriculum" role="tabpanel" aria-labelledby="pills-Curriculum-tab">
                
                                    <div>
                                        <div class="card course-card mb-4">
                                            <div class="card-body">
                                                <div class="d-lg-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <h4 class="mb-1">{{ $courseDetails->title }}</h4>
                                                    </div>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($courseDetails->getVideos as $video)
                                                    <li class="list-group-item course-price-itmes px-0">
                                                        <div class="d-md-flex justify-content-between align-items-center">
                
                                                            <h5 class="mb-0">{{ $i.'. ' }}{{ ($video->name == null) ? 'Video' : $video->name }}</h5>
                                                        </div>
                                                    </li>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
        <!-- sidebar -->
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12 mb-8">
                        <div class="card course-card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-tie mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Coach</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-dark">{{ ($courseDetails->author == 0) ? 'Admin' :  $courseDetails->authorName->firstName.' '.$courseDetails->authorName->lastName}}</h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-fw fa-thumbs-up mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Likes</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">{{ count($courseDetails->getLikes) }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <i class="far fa-fw fa-comments mr-2 font-16 fa-fw text-muted"></i>
                                                <h5 class="mb-0 font-weight-medium">Comments</h5>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">{{ $courseDetails->getComments->total() }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item course-price-itmes py-3">
                                    <a href="{{ url('/watch-course/'.Crypt::encryptString($courseDetails->id)) }}" class="btn btn-secondary btn-block" target="_blank">Watch Now</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="container justify-content-center comment-container">
            <div class="d-flex justify-content-center pt-3 pb-2"> 
                <form action="{{ url('/post-comment') }}" method="POST" class="comment-form d-flex">
                    @csrf
                    <input type="hidden" name="courseId" value="{{ Crypt::encryptString($courseDetails->id) }}">
                    <input type="text" name="comment" required placeholder="+ Add Your Comment" class="form-control addtxt">
                    <button type="submit" class="btn btn-primary primary-background-color form-button">Post Comment</button>
                </form> 
            </div>
            @foreach ($courseDetails->getComments as $comment)
            <div class="d-flex justify-content-center py-2 pb-3">
                <div class="second py-2 px-2"> <span class="text1">{{ $comment->comment }}</span>
                    <div class="d-flex justify-content-between py-1 pt-2">
                        
                        <div>{!! ($comment->userImage != null) ? '<img src="'. asset('storage/'.$comment->userImage) .'" alt="'. $comment->userFirstName.' '. $comment->userLastName .'" width="18" />' : '<i class="align-middle fas fa-fw fa-user"></i>' !!}<span class="text2">{{ $comment->userFirstName.' '. $comment->userLastName }}</span></div>
                        
                    </div>
                </div>
            </div>
            @endforeach
            <div class="d-flex justify-content-center py-2 pb-3">
            {{ $courseDetails->getComments->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
@include('layouts.footer')