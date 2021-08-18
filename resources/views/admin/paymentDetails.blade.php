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
@endsection
@include('layouts.admin.footer')