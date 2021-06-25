@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Subscriptions
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
                                <h5 class="card-title">Subscriptions Table</h5>
                            </div>
                            <div class="col-4">
                               <a href="{{ url('admin/add-subscription') }}"><span class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Subscription</span></a> 
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            
                            <tr>
                                <th style="width:40%;">Name</th>
                                <th style="width:25%">Vaidity in Days</th>
                                <th class="d-none d-md-table-cell" style="width:25%">Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->name }}</td>
                                <td>{{ $subscription->validity }}</td>
                                <td class="d-none d-md-table-cell">{{ $subscription->price }}</td>
                                <td class="table-action">
                                    <a href="{{ url('admin/edit-subscription/'.Crypt::encryptString($subscription->id)) }}"><i class="align-middle fas fa-fw fa-pen"></i></a>
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