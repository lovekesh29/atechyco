@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Courses
            </h1>
            <nav aria-label="breadcrumb">
                <span class="header-title"><strong>Course Name: </strong>{{ $videosData[0]->getCourse->title }} </span>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Videos Table</h5>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                
                                <th style="width:25%">Video Name</th>
                                <th style="width:40%;">Video Description</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Video Url</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($videosData as $videoData)
                            <tr>
                                @php
                                    $videoId = App\Http\Controllers\Controller::getVideoId($videoData->videoUrl);
                                    $fullVideoLink = config('vimeo.vimeoMailLink').$videoId;
                                @endphp
                                <td>{!! ($videoData->name != null) ? $videoData->name : '<a href="'. url("admin/video/".Crypt::encryptString($videoData->videoUrl)) .'">Click Here To Add Name & Description' !!}</td>
                                <td>{!! $videoData->description !!}</td>
                                <td class="d-none d-md-table-cell"> <a href="{{ $fullVideoLink }}" target="_blank">Watch Video</a></td>
                                <td class="table-action">
                                    <a href="{{ url("admin/video/".Crypt::encryptString($videoData->videoUrl)) }}"><i class="align-middle fas fa-fw fa-pen"></i></a>
                                    <a href="#"><i class="align-middle fas fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $videosData->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@include('layouts.admin.footer')