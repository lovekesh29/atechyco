@section('header')
@php
    use App\Models\Categories;
    $categories = Categories::with('getSubCategories')->get();
@endphp
<div class="navbar container-fluid nav-top">
    <div class="row">
        <div class="col-lg-4 col-sm-4 col-4 ">
            <a class="navbar-brand" href="{{ url('/') }}">Your Comapny Name</a>
        </div>
        <div class="col-lg-2 offset-lg-6 offset-sm-6 col-sm-2 col-3 offset-5">
            <a href="{{ url('/sign-up') }}" class="btn signup-btn primary-background-color float-right me-2" type="submit">Sign Up</a>
        </div>
    </div>
        
</div>
<div class="stellarnav">
    <ul class="stellarnav-ul">
        <li><a href="{{ url('/courses') }}">Courses</a></li>
        <li><a href="">Categories</a>
            <ul>
                @foreach ($categories as $category)
                @if (count($category->getSubCategories) != 0)
                <li><a href="#">{{ $category->name }}</a>
                    <ul>
                        @foreach ($category->getSubCategories as $subCategory)
                        <li><a href="{{ url('/courses?sub_cat='.Crypt::encryptString($subCategory->id)) }}">{{ $subCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endif
                @endforeach
            </ul>
        </li>

        
        <li class="float-right search-li">
            <form action="{{ url('/courses') }}" method="get">
                @csrf
                <input class="form-control top-search me-2 @error('serachCourse') is-invalid @enderror" required type="text" value="{{ old('serachCourse') }}" name="serachCourse" placeholder="Search" aria-label="Search">
            </form>
            
        </li>
        
    </ul>
</div>
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-black">
        <div class="container-fluid navbar-container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="row">
                    <div class="col-lg-10">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ url('/courses') }}">Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact Us</a>
                            </li>
                            <li class="nav-item facebook-icon">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <form class="d-flex">
                            <input class="form-control top-search me-2" type="search" placeholder="Search" aria-label="Search">
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </nav> --}}
    @endsection