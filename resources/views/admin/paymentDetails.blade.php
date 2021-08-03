@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Payments
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
                                <h5 class="card-title">Payments Table</h5>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th >S. No.</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Payment Id</th>
                                <th>Price Paid</th>
                                <th>Currency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($paymentDetails as $paymentDetail)
                            <tr>
                                <td> {{ $i.'. ' }}</td>
                                <td> {{ $paymentDetail->getUser[0]->firstName.' '.$paymentDetail->getUser[0]->lastName }} </td>
                                <td> {{ $paymentDetail->getUser[0]->email }} </td>
                                <td> {{ $paymentDetail->paymentId }} </td>
                                <td> {{ $paymentDetail->amount }} </td>
                                <td> {{ $paymentDetail->currency }} </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="custom-pagination">
                        {{ $paymentDetails->links('vendor.pagination.bootstrap-4') }}
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