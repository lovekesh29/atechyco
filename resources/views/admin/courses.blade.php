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
                                <h5 class="card-title">Courses Table</h5>
                                
                            </div>
                            <div class="col-4">
                               <a href="{{ url('admin/upload-courses') }}"><span class="btn btn-primary float-right"><i class="fas fa-upload"></i> Upload Courses</span></a> 
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th style="width:40%;">Title</th>
                                <th style="width:25%">Author</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr>
                                <td> <a href="{{ url('admin/course/view-videos/'.Crypt::encryptString($course->id)) }}">{{ substr($course->title, 0, 50) }}</a> </td>
                                <td>{{ ($course->author == 0)  ? 'Admin' :  $course->authorName->firstName.' '.$course->authorName->lastName }}</td>
                                <td class="d-none d-md-table-cell">{!! substr($course->description, 0, 50) !!}</td>
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