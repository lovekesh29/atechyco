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
                Course Video
            </h1>
            <nav aria-label="breadcrumb">
                <span class="header-title">Edit Video Meta</span>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Video Meta</h5>
                    </div>
                    <div class="card-body">
                        @error('videoUrl')
                        <label class="error small form-text invalid-feedback">{{ $message }}</label>
                        @enderror
                        <form action="{{ url('/admin/upload-videoMeta') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" required name="videoUrl" value="{{ Crypt::encryptString($videoDetails->videoUrl) }}">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Video Name</label>
                                    <input type="text" name="name" value="{{ $videoDetails->name }}" class="@error('name') is-invalid @enderror form-control" required placeholder="Video Name">
                                    @error('name')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Video Descritpion</label>
                                    <textarea name="description" class="@error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ $videoDetails->description }}</textarea>
                                    @error('description')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Video Order</label>
                                    <input type="number" required value="{{ $videoDetails->videoOrder }}" name="videoOrder" class="@error('videoOrder') is-invalid @enderror form-control">
                                    @error('videoOrder')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            
                        
                            <div class="form-row input-group" >
                                <div class="form-group col-md-6">
                                    <label>Video Thumbnil</label>
                                    <input type="file" name="videoThumbnil" class="myfrm form-control file-upload">
                                </div>
                                <div class="col-md-6">
                                    {!! ($videoDetails->videoThumbnil != null) ? '<img src="'. asset('storage/'.$videoDetails->videoThumbnil) .'" class="img-fluid rounded-circle mb-2" alt="'. $videoDetails->name .'" style="width: 134px;" />' : '' !!}
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