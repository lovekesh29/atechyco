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
                Add Page
            </h1>
            <nav aria-label="breadcrumb">
                @include('layouts.admin.breadcrumb')
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add Page</h5>
                        <h6 class="card-subtitle text-muted">Add Page</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/add-page') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Banner Heading</label>
                                    <input type="text" name="bannerHeading" class="@error('bannerHeading') is-invalid @enderror form-control" required placeholder="Banner Heading">
                                    @error('bannerHeading')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Page Heading</label>
                                    <input type="text" name="pageHeading" class="@error('pageHeading') is-invalid @enderror form-control" required placeholder="Page Heading">
                                    
                                    @error('pageHeading')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Page Url</label>
                                    <input type="text" name="pageUrl" class="@error('pageUrl') is-invalid @enderror form-control" required placeholder="Page Url">
                                    <small class="text-primary">Enter the url without spaces</small>
                                    
                                    @error('pageUrl')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Page Content</label>
                                    <textarea required name="pageContent" class="@error('pageContent') is-invalid @enderror" id="pageContent" cols="30" rows="10">Type Page Content Here</textarea>
                                    
                                    @error('pageContent')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Meta Title</label>
                                    <input type="text" name="metaTitle" class="@error('metaTitle') is-invalid @enderror form-control" required placeholder="Page Heading">
                                    
                                    @error('metaTitle')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Meta Description</label>
                                    <input type="text" name="metaDescription" class="@error('metaDescription') is-invalid @enderror form-control" required placeholder="Page Heading">
                                    
                                    @error('metaDescription')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-row input-group" >
                                <div class="form-group col-md-6">
                                    <label>Select Banner Image</label>
                                    <input type="file" multiple name="bannerImage" class="myfrm form-control file-upload">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Page Image</label>
                                    <input type="file" name="pageImage" class="myfrm form-control file-upload">
                                </div>
                            </div>
                            <button type="submit" class="btn  btn-primary">Submit</button>
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