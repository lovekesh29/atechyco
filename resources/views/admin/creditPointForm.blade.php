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
                Settings
            </h1>
            <nav aria-label="breadcrumb">
                @include('layouts.admin.breadcrumb')
            </nav>
        </div>
        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#creditForm" role="tab" aria-selected="true">
                            Set Credit Points
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="creditForm" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Set Credit Points</h5>
                                <form action="{{ url('admin/set-credit-points') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Credit Points</label>
                                        <input type="number" min="0" value="{{ $creditPoints->creditPoints }}" name="creditPoints" required class="form-control @error('creditPoints') is-invalid @enderror">
                                        @error('creditPoints')
                                        <label class="error small form-text invalid-feedback">This field is required.</label>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@include('layouts.admin.footer')