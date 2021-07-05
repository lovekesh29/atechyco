@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Gurus
            </h1>
            <nav aria-label="breadcrumb">
                @include('layouts.admin.breadcrumb')
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Gurus Table</h5>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gurus as $guru)
                            <tr>
                                <td>
                                    {!! ($guru->imgPath != null) ? '<img src="'.asset('storage/'.$guru->imgPath).'" width="48" height="48" class="rounded-circle mr-2" alt="Avatar">' : '<i class="align-middle fas fa-fw fa-guru"></i>' !!}
                                     {{ $guru->firstName.' '.$guru->lastName }}
                                </td>
                                <td>{{ $guru->email }}</td>
                                <td>{{ $guru->phoneNo }}</td>
                                <td>{{ $guru->age }}</td>
                                <td>{{ config('custom.gender.'.$guru->gender) }}</td>
                                <td>{{ ($guru->location != null) ? $guru->country->countryName : '' }}</td>
                                <td class="table-action">
                                    <a href="{{ url('/admin/edit-guru/'.Crypt::encryptString($guru->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit guru"><i class="align-middle fas fa-fw fa-user-edit"></i></a>
                                    {!! ($guru->status == 1) ? '<a href="#" class="guru-status" data-status="'.$guru->status.'" id="guru_'.$guru->id.'" data-toggle="tooltip" data-placement="top" title="Block guru"><i class="align-middle fas fa-fw fa-ban"></i></a>' : '<a href="#" data-status="'.$guru->status.'" class="guru-status" id="guru_'.$guru->id.'" data-toggle="tooltip" data-placement="top" title="Approve guru"><i class="align-middle fas fa-fw fa-check-circle"></i></a>' !!}
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