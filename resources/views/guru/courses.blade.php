@extends('layouts.guru.app')
@include('layouts.guru.sidebar', ['guru' => Auth::guard('guru')->user()])
@include('layouts.guru.header', ['guru' => Auth::guard('guru')->user()])
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                My Courses
            </h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Courses Table</h5>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th style="width:40%;">Title</th>
                                <th style="width:25%">Likes</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Comments</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Current View</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Completely Watched</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guruCourses as $guruCourse)
                            <tr>
                                <td> {{ substr($guruCourse->title, 0, 50) }} </td>
                                <td>{{ count($guruCourse->getLikes) }}</td>
                                <td>{{ count($guruCourse->getComments) }}</td>
                                <td>{{ count($guruCourse->getCurrentView) }}</td>
                                <td>{{ count($guruCourse->getCompletedCourses) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $guruCourses->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.guru.footer')