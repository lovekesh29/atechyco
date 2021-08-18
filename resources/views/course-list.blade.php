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
@if (Session::has('warning'))
<script>
    swal({
        icon: "warning",
        title: 'No Courses',
        text: "{{ Session::get('warning') }}"
    })
</script>    
@endif
    <section class="course-banner d-flex">
            <div class="container">
                <div class="row"> 
                    <div class="col-lg-12 col-sm-12 align-items-center d-flex justify-content-center course-banner-row">
                        <div class="banner-content course-banner-content">
                            <h1>Courses</h1>
                        </div>
                    </div>
                </div>
                
            </div>
    </section>
    <section class="course-description main-page-section">
        <div class="container section-container">
            <div class="pt-lg-12 pb-lg-12 py-6 ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="d-md-flex justify-content-between mb-3">
                                <div>
                                    <h4>Courses available for you</h4>
                                </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- course thumbnail -->
                        @foreach ($courses as $course)
                        @php
                            $type = 0;
                            $likesDislike = $course->getRelation('getLikes')->toarray();

                            if(Auth::check() && array_search(Auth::id(), array_column($likesDislike, 'userId')) !== false){
                                $type = 1;
                            }
                        @endphp
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="mb-4">
                                <a href="course-single.html">
                                    <img src="{{ url('/storage/courseImage/'.$course->id.'/'.$course->courseImage) }}" alt="" class="img-fluid w-100 border-top border-top-5 border-primary rounded-top">
                                </a>
                                <div class="card-body p-4 border border-top-0 rounded-bottom bg-white course-card">
                                    <a href="{{ url('view-course/'.Crypt::encryptString($course->id)) }}">
                                        <h4 class="mb-3 course-heading">{{ substr($course->title, 0, 22).'...'  }}</h4>
                                    </a>
                                    <p class="font-13 font-weight-bold"><span class="mr-2">{{ count($course->getVideos) }} Videos</span> <span class="mr-2">{{ count($course->getLikes) }} Likes</span><span class="mr-2">{{ count($course->getComments) }} Comments</span></p>
                                    <a href="{{ url('view-course/'.Crypt::encryptString($course->id)) }}" class="btn btn-primary btn-sm primary-background-color form-button">View Now</a>
                                    
                                    <div class="d-flex flex-row fs-12">
                                        <a href="javascript:void(0)" class="like-button" data-type="{{ ($type == 1) ? '0' : '1' }}" data-courseId="{{ Crypt::encryptString($course->id) }}"><div class="like p-2 cursor comment-section"><i class="fas fa-fw fa-thumbs-up {{ ($type == 1) ? 'active' : '' }}" id="likeIcon_{{ Crypt::encryptString($course->id) }}"></i><span class="ml-1">Like</span></div></a> 
                                        {{-- @if (Auth::check()) --}}
                                        <a href="javascript:void(0)" class="comment-modal" id="{{ Crypt::encryptString($course->id) }}"><div class="like p-2 cursor comment-section" ><i class="far fa-fw fa-comments"></i><span class="ml-1">Comment</span></div></a>
                                        {{-- @endif --}}

                                        <a href="javascript:void(0)" class="share-modal" data-shortUrl="" id="{{ Crypt::encryptString($course->id) }}"><div class="like p-2 cursor comment-section"><i class="fas fa-fw fa-share"></i><span class="ml-1">Share</span></div></a>
                                    </div>
                                    
                                   
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                    {{ $courses->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="commentCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Post Your Comment</h5>
            <button type="button" class="close comment-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/post-comment') }}" method="POST" class="contact-us-form">
                    @csrf
                    <input type="hidden" name="courseId" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Type Your Comment</label>
                        <input type="text" name="comment" required class="form-control" id="exampleInputEmail1" placeholder="Type Your Comment">
                    </div>
                    <button type="submit" class="btn btn-primary primary-background-color form-button">Post Comment</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Share Url</h5>
            <button type="button" class="close share-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Copy This Url</label>
                    <input type="text" readonly name="shareUrl" class="form-control" >
                </div>
                <div class="share-icons d-flex justify-content-center">
                    <img class="img-fluid social-icon rounded-circle mb-2" src="{{ url('/images/facebook.png') }}" alt="">
                    <img class="img-fluid social-icon rounded-circle mb-2" src="{{ url('/images/twitter.png') }}" alt="">
                    <img class="img-fluid social-icon rounded-circle mb-2" src="{{ url('/images/instagram.png') }}" alt="">
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@include('layouts.footer')