@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
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
        <div class="header">
            <h1 class="header-title">
                Comments
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
                            <div class="col-6">
                                <h5 class="card-title">Comments Table</h5>
                            </div>
                        </div>
                        
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th>S. No.</th>
                                <th>User</th>
                                <th>User Email</th>
                                <th>Course</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($comments as $comment)
                            <tr>
                                <td> {{ $i.'. ' }}</td>
                                <td> {{ $comment->getUser->firstName }}</td>
                                <td> {{ $comment->getUser->email }}</td>
                                <td> {{ $comment->getCourse->title }}</td>
                                <td> {{ $comment->comment }}</td>
                                <td class="table-action">
                                    {!! ($comment->status == 1) ? '<a href="javascript:void(0)" class="comment-status" id="'.Crypt::encryptString($comment->id).'" data-status="'.$comment->status.'" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate Comment"><i class="align-middle fas fa-fw fa-ban"></i></a>' : '<a href="javascript:void(0)" class="comment-status" data-status="'.$comment->status.'" id="'.Crypt::encryptString($comment->id).'" data-toggle="tooltip" data-placement="top" data-original-title="Activate Comment"><i class="align-middle fas fa-fw fa-check-circle"></i></a>' !!}
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $comments->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.admin.footer')