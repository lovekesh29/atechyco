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
                @include('layouts.admin.breadcrumb')
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
                                <th style="width:40%;">Course Name</th>
                                <th style="width:25%">Video Name</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Video Url</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($videosData as $videoData)
                            <tr>
                                <td>{{ $videoData->getCourse->title }}</td>
                                <td>{{ $videoData->name }}</td>
                                <td class="d-none d-md-table-cell">{{ $videoData->videoUrl }}</td>
                                <td class="table-action">
                                    <a href="#"><i class="align-middle fas fa-fw fa-pen"></i></a>
                                    <a href="#"><i class="align-middle fas fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@include('layouts.admin.footer')