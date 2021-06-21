@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Users
            </h1>
            <nav aria-label="breadcrumb">
                @include('layouts.admin.breadcrumb')
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Courses Table</h5>
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
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    {!! ($user->imgPath != null) ? '<img src="'.asset('storage/'.$user->imgPath).'" width="48" height="48" class="rounded-circle mr-2" alt="Avatar">' : '<i class="align-middle fas fa-fw fa-user"></i>' !!}
                                     {{ $user->firstName.' '.$user->lastName }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phoneNo }}</td>
                                <td>{{ $user->age }}</td>
                                <td>{{ config('custom.gender.'.$user->gender) }}</td>
                                <td>{{ ($user->location != null) ? $user->country->countryName : '' }}</td>
                                <td class="table-action">
                                    <a href="{{ url('/admin/edit-user/'.Crypt::encryptString($user->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="align-middle fas fa-fw fa-user-edit"></i></a>
                                    {!! ($user->status == 1) ? '<a href="#" class="user-status" data-status="'.$user->status.'" id="user_'.$user->id.'" data-toggle="tooltip" data-placement="top" title="Block User"><i class="align-middle fas fa-fw fa-ban"></i></a>' : '<a href="#" data-status="'.$user->status.'" class="user-status" id="user_'.$user->id.'" data-toggle="tooltip" data-placement="top" title="Approve User"><i class="align-middle fas fa-fw fa-check-circle"></i></a>' !!}
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