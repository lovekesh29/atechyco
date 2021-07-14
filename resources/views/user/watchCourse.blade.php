@extends('layouts.user.app')
@include('layouts.user.sidebar', ['user' => Auth::user()])
@include('layouts.user.header', ['user' => Auth::user()])
@section('home')
<script>
    var videostatus = '';
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
    $videoId = App\Http\Controllers\Controller::getVideoId($videoDetails->videoUrl);
    $systemVideoId = $videoDetails->id;
    if($videoDetails->status == 'paused'){
        echo "<script> videostatus = 'paused' </script>";
    }
@endphp
<main class="content">
    <div class="container-fluid">
        @include('templates.user.dashboardHeader', ['user' => Auth::user()])
        
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Watch Course</h5>
                    </div>
                    <div class="card-body popular-course py-3">
                        <div id="{{ 'video_'.$videoId }}"></div>
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
    var options01 = {
      id: "{{ $videoId }}"
    };
    var video01Player = new Vimeo.Player("{{ 'video_'.$videoId }}", options01);
    if(videostatus == 'paused'){
        video01Player.setCurrentTime("{{$videoDetails->time}}")
    }

    video01Player.on('pause', function(data) {
        $.ajax({
                type: "GET",
                url: siteUrl + '/update-video-status',
                data: { systemVideoId: "{{ Crypt::encryptString($systemVideoId) }}", status: 0, time: data.seconds},
                success: function(data) {
                    console.log(data);
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
                data: { systemVideoId: "{{ Crypt::encryptString($systemVideoId) }}", status: 1, time: data.seconds},
                success: function(data) {
                    console.log(data);
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