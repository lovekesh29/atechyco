@extends('layouts.user.app')
@include('layouts.user.sidebar', ['user' => Auth::user()])
@include('layouts.user.header', ['user' => Auth::user()])
@section('home')
<script>
    var courseStatus = '';
</script>
@if (Session::has('status'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('status') }}"
    })
</script>    
@endif
@php
    $vimeoVideoId = App\Http\Controllers\Controller::getVideoId($videoToBeWatched->videoUrl);
    $systemVideoId = $videoToBeWatched->id;
    if($videoToBeWatched->status == 'paused'){
        echo "<script> courseStatus = 'paused' </script>";
    }
@endphp
<main class="content">
    <div class="container-fluid">
        @include('templates.user.dashboardHeader', ['user' => Auth::user()])
        
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $videoToBeWatched->videoOrder.'. '. $videoToBeWatched->name}}</h5>

                    </div>
                    <div class="card-body popular-course py-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <iframe id="course-video-palyer" src="https://player.vimeo.com/video/{{$vimeoVideoId}}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="width: 500px; height: 500px"></iframe>
                                </div>
                                
                            </div>
                                <div class="row">
                                    <div class="col-10 mx-auto">
                                        <h4 class="card-title mb-0">Course Videos</h4>
                                        <div class="accordion" id="faqExample">
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($courseVideos as $courseVideo)
                                            <div class="card">
                                                <div class="card-header p-2" id="headingOne_{{$i}}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne_{{$i}}" aria-expanded="false" aria-controls="collapseOne_{{$i}}">{{$courseVideo->videoOrder.'. '}} 
                                                          {{ ($courseVideo->name == null) ? 'Video '.$i : $courseVideo->name }}
                                                          
                                                        </button>
                                                        <div class="float-right mt-n1">
                                                            <a class="btn btn-primary btn-sm video-play"
                                                            id="{{ App\Http\Controllers\Controller::getVideoId($courseVideo->videoUrl) }}" href="{{ url('/watch-course/'.Crypt::encryptString($courseVideo->courseId).'/'.$courseVideo->id) }}">View</a>
                                                        </div>
                                                      </h5>
                                                </div>
                            
                                                <div id="collapseOne_{{$i}}" class="collapse" aria-labelledby="headingOne_{{$i}}" data-parent="#faqExample">
                                                    <div class="card-body">
                                                        {{ ($courseVideo->description == null) ? 'Video Description' : $courseVideo->description }}
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>



    </div>
</main>
@endsection
@section('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    var iframe = document.querySelector('iframe');
    var video01Player = new Vimeo.Player(iframe);
    if(courseStatus == 'paused'){
        video01Player.setCurrentTime("{{$videoToBeWatched->time}}")
    }

    video01Player.on('pause', function(data) {
        $.ajax({
                type: "GET",
                url: siteUrl + '/update-video-status',
                data: { systemVideoId: "{{ Crypt::encryptString($systemVideoId) }}", status: 0, time: data.seconds},
                success: function(data) {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal({
                        icon: "error",
                        title: ajaxOptions,
                        text: thrownError
                    });
                }
            })
    });
    video01Player.on('ended', function(data) {
        $.ajax({
                type: "GET",
                url: siteUrl + '/update-video-status',
                data: { systemVideoId: "{{ Crypt::encryptString($systemVideoId) }}", courseId: "{{ Crypt::encryptString($videoToBeWatched->courseId) }}", status: 1, time: data.seconds},
                success: function(data) {
                    data = JSON.parse(data);
                    if(data.message == 'courseCompleted'){
                        window.location.href =  siteUrl  + "/my-classroom";
                    } else if(data.message == 'videoEnded'){
                        window.location.href =  siteUrl  + "/watch-course/{{ Crypt::encryptString($videoToBeWatched->courseId) }}";
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal({
                        icon: "error",
                        title: ajaxOptions,
                        text: thrownError
                    });
                }
            })
    });

    
</script>

@endsection
@include('layouts.user.footer')