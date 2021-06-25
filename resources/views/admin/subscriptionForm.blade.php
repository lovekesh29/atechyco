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
                Add Subscriptions
            </h1>
            <nav aria-label="breadcrumb">
                @include('layouts.admin.breadcrumb')
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add Subcription</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/add-subscription') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" required placeholder="Couse Title" value="{{ old('name') }}">
                                    @error('name')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Validity</label>
                                    <input type="number" min="0" name="validity" class="@error('validity') is-invalid @enderror form-control" required placeholder="Couse Title" value="{{ old('validity') }}">
                                    @error('validity')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Price</label>
                                    <input type="number" min="0" name="price" class="@error('price') is-invalid @enderror form-control" required placeholder="Couse Title" value="{{ old('price') }}">
                                    @error('price')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Subscription Descritpion</label>
                                    <textarea name="description" class="@error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                    @error('description')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
</script>
@endsection
@include('layouts.admin.footer')