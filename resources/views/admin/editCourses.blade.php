@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
@if (Session::has('successfull'))
<script>
    swal({
        icon: "success",
        title: 'Success',
        text: "Course Updated Successfully"
    })
</script>  
@endif
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Edit Courses
            </h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Course Edit</h5>
                        <h6 class="card-subtitle text-muted">Edit Complete Course Details</h6>
                    </div>
                    <div class="card-body">
                        @error('courseId')
                        <label class="error small form-text invalid-feedback">{{ $message }}</label>
                        @enderror
                        <form action="{{ url('/admin/update-course') }}" method="POST" id="courseForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="courseId" value="{{ Crypt::encryptString($courseDetail->id) }}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Title</label>
                                    <input type="text" name="title" class="@error('title') is-invalid @enderror form-control" required placeholder="Couse Title" value="{{ $courseDetail->title }}">
                                    @error('title')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Course Author</label>
                                    <select name="author" required class="@error('author') is-invalid @enderror form-control">
                                        <option selected="" value="{{ ($courseDetail->author == 0)  ? 0 :  $courseDetail->authorName->id}}">{{ ($courseDetail->author == 0)  ? 'Admin' :  $courseDetail->authorName->firstName }}</option>

                                        {{ ($courseDetail->author == 0)  ? '' : '<option value="0">Admin</option>' }}
                                    
                                        
                                        @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->firstName }}</option>
                                        @endforeach
                                    </select>
                                    @error('author')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Course Descritpion</label>
                                    <textarea required name="description" class="@error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ $courseDetail->description }}</textarea>
                                    @error('description')
                                    <label class="error small form-text invalid-feedback">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row input-group zzz" >
                                <div class="form-group col-md-12">
                                    <input type="file" multiple name="videoFiles[]" class="myfrm form-control file-upload">
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