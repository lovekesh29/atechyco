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
                Categories
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
                                <h5 class="card-title">Categories Table</h5>
                            </div>
                            <div class="col-3">
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#categoryModal"><span class="btn btn-primary float-right"><i class="align-middle fas fa-fw fa-plus"></i> Add Categories</span></a> 
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
                                <th style="width:25%">S. No.</th>
                                <th style="width:40%;">Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($categories as $category)
                            <tr>
                                <td> {{ $i.'. ' }}</td>
                                <td> <a href="{{ url('/admin/sub-cat/'.Crypt::encryptString($category->id)) }}">{{ $category->name }} </a></td>
                                <td class="table-action">
                                    <a href="javascript:void(0)" class="categoryEditModal" data-category-name="{{ $category->name }}" id="{{ Crypt::encryptString($category->id) }}"><i class="align-middle fas fa-fw fa-pen"></i></a>
                                    {!! ($category->status == 1) ? '<a href="javascript:void(0)" class="category-status" id="'.Crypt::encryptString($category->id).'" data-status="'.$category->status.'" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate Category"><i class="align-middle fas fa-fw fa-ban"></i></a>' : '<a href="javascript:void(0)" class="category-status" data-status="'.$category->status.'" id="'.Crypt::encryptString($category->id).'" data-toggle="tooltip" data-placement="top" data-original-title="Activate Category"><i class="align-middle fas fa-fw fa-check-circle"></i></a>' !!}
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $categories->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url('/admin/add-category') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" required placeholder="Category Name">
                            @error('name')
                            <label class="error small form-text invalid-feedback">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="category-edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url('/admin/edit-category') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="close close-edit" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    @csrf
                    <input type="hidden" name="categoryId">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" name="categoryEditName" class="@error('categoryEditName') is-invalid @enderror form-control" required placeholder="Category Name">
                            @error('categoryEditName')
                            <label class="error small form-text invalid-feedback">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@include('layouts.admin.footer')