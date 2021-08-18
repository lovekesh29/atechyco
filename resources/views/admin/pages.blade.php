@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
@if (Session::has('successfull'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "{{ Session::get('successfull') }}"
    })
</script>  
@endif
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Pages
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
                                <h5 class="card-title">Pages Table</h5>
                                
                            </div>
                            <div class="col-4">
                               <a href="{{ url('admin/add-page') }}"><span class="btn btn-primary float-right"><i class="fas fa-upload"></i> Add Page</span></a> 
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th style="width:40%;">Page Heading</th>
                                <th style="width:25%">Page Url</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                            <tr>
                                <td> <a href="{{ url('/'.$page->pageUrl) }}">{{ substr($page->pageHeading, 0, 50) }}</a> </td>
                                <td>{{ $page->pageUrl }}</td>
                                <td class="d-none d-md-table-cell">{!! substr($page->pageContent, 0, 50) !!}</td>
                                <td class="table-action">
                                    <a href="{{ url('admin/edit-page/'.Crypt::encryptString($page->id)) }}"><i class="align-middle fas fa-fw fa-pen"></i></a>
                                    {!! ($page->status == '1') ? '<a href="#" class="page-status" id="'.Crypt::encryptString($page->id).'" data-status="'.$page->status.'" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate Page"><i class="align-middle fas fa-fw fa-ban"></i></a>' : '<a href="#" class="page-status" data-status="'.$page->status.'" id="'.Crypt::encryptString($page->id).'" data-toggle="tooltip" data-placement="top" data-original-title="Activate Page"><i class="align-middle fas fa-fw fa-check-circle"></i></a>' !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $pages->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.admin.footer')