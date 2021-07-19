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
            @foreach ($courses as $course)
            <div class="col-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <h6 class="card-subtitle text-muted">By: {{ ($course->author == 0) ? 'Admin' :  $course->authorName->firstName }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <div id="tasks-upcoming">
                            <div class="card mb-3 bg-light cursor-grab">
                                <div class="card-body p-3">
                                    {!! $course->description !!}
                                    <div class="float-right mt-n1">
                                        <img src="img/avatars/avatar.jpg" width="32" height="32" class="rounded-circle" alt="Avatar">
                                    </div>
                                    <a class="btn btn-primary btn-sm" target="_blank" href="{{ url('/watch-course/'.Crypt::encryptString($course->id)) }}">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
@include('layouts.user.footer')