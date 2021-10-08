@extends('layouts.app')
@include('layouts.header')
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
    <section class="banner">
            <div class="container">
                <div class="col-lg-5 offset-lg-7 col-sm-12">
                    <div class="banner-content" data-aos="zoom-in">
                        <h1>Welcome To</h1>
                        <span class="primary-color">Your Company</span>
                    </div>
                </div>
            </div>
    </section>
    <section class="trending-courses main-page-section">
        <div class="container section-container">
            <div class="section-heading text-center">
                <h2>Trending Courses</h2>
                <hr width="25%" align="center">
            </div>
            <p class="text-center course-content">some random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome
                random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random text</p>
   
            <div class="row" data-aos="zoom-in">
                @foreach ($trendingCourses as $trendingCourse)
                <div class="col-lg-4 col-md-4 col-sm-12 crousal-element">
                    <div class="card">
                        <img src="{{ url('/storage/courseImage/'.$trendingCourse->id.'/'.$trendingCourse->courseImage) }}" style="width: 346px; height: 206px" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $trendingCourse->name }}</h5>
                            <p class="card-text">{!! substr($trendingCourse->description, '0', '50') !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="new-courses main-page-section">
        <div class="container section-container">
            <div class="section-heading text-center">
                <h2>Recent/New Courses</h2>
                <hr width="25%" align="center">
            </div>
            <p class="text-center course-content">some random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome
                random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random text</p>

                <div class="row" data-aos="zoom-in">
                    @foreach ($recentCourses as $recentCourse)
                    <div class="col-lg-4 col-md-4 col-sm-12 crousal-element">
                        <div class="card">
                            <img src="{{ url('/storage/courseImage/'.$recentCourse->id.'/'.$recentCourse->courseImage) }}" style="width: 346px; height: 206px" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $recentCourse->name }}</h5>
                                <p class="card-text">{!! substr($recentCourse->description, '0', '50') !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>

    </section>
    <section class="suggested-courses main-page-section">
        <div class="container section-container suggested-slider">
            <div class="section-heading text-center">
                <h2>Suggested Courses</h2>
                <hr width="25%" align="center">
            </div>
            <p class="text-center course-content">some random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome
                random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random textsome random text</p>

                <div class="row" data-aos="zoom-in">
                    @foreach ($suggestedCourses as $suggestedCourse)
                    <div class="col-lg-4 col-md-4 col-sm-12 crousal-element">
                        <div class="card">
                            <img src="{{ url('/storage/courseImage/'.$suggestedCourse->id.'/'.$suggestedCourse->courseImage) }}" style="width: 346px; height: 206px" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $suggestedCourse->name }}</h5>
                                <p class="card-text">{!! substr($suggestedCourse->description, '0', '50') !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </section>
    <section class="contact-us main-page-section">
        <div class="container contact-us-div">
            <div class="section-heading text-center">
                <h2>Contact Us</h2>
            </div>
            <p class="text-center course-content">Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some
                Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text Some Random text </p>

            <form class="contact-us-form" action="{{ url('/contact-us') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label margin-label">Full Name</label>
                        <input type="text" name="fullName" required class="form-control @error('fullName') is-invalid @enderror" value="{{ old('fullName') }}" placeholder="Sam Kuran">
                        @error('fullName')
                            <div class="alert alert-danger" role="alert">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com">
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="exampleFormControlTextarea1" class="form-label">Describe Your Query</label>
                        <textarea class="form-control @error('formQuery') is-invalid @enderror" name="formQuery" required id="exampleFormControlTextarea1" rows="8">{{ old('formQuery') }}</textarea>
                        @error('formQuery')
                            <div class="alert alert-danger" role="alert">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn form-button primary-background-color float-right me-2" type="submit">Contact Us</button>
                    </div>
                </div>
            </form>
        </div>

    </section>
    
    
@endsection
@include('layouts.footer')