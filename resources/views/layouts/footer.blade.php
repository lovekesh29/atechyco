@section('footer')
<footer class="main-page-section">
        <div class="container subscribe-div">
            <div class="footer-subscribe-section">
                <div class="right-subscribe">
                    <div class="right-subscribe-bg">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5 col-sm-12 subscribe-content">
                                    <h2>Subscribe To Our NewsLetter</h2>
                                    <p>Some Random Text Some Random Text Some Random Text Some Random Text lorem50</p>
                                </div>
                                <div class="col-lg-4 offset-lg-2 col-sm-12 subscribe-form">
                                    <form action="{{ url('/subscribe') }}" method="POST" class="">
                                        @csrf
                                        <div class="col-lg-12">
                                            <input type="email" name="newsLetterEmail" value="{{ old('newsLetterEmail') }}" class="form-control @error('newsLetterEmail') is-invalid @enderror subscribe-input" id="exampleFormControlInput1" placeholder="name@example.com">
                                            @error('newsLetterEmail')
                                                <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn form-button subscribe-button me-2" type="submit">Subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="container main-footer">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <h3>About Us</h3>
                    <p>Some Random Text</p>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <h3>Use Full Links</h3>
                    <ul>
                        <li>Link 1</li>
                        <li>Link 2</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <h3>Use Full Links</h3>
                    <ul>
                        <li>Link 1</li>
                        <li>Link 2</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="phone d-flex">
                        <i class="fas fa-phone-alt phone-icon"></i>
                        <div class="phone-text">
                            <p class="phone-number">9896788095</p>
                            <p class="phone-number">9896788095</p>
                        </div>
                    </div>
                    <div class="phone d-flex">
                        <i class="fas fa-map-marker-alt phone-icon"></i>
                        <div class="phone-text">
                            <p class="phone-number">This is the sample address</p>
                            <p class="phone-number">This is the sample address Line 2</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-8">
                    <p class="float-left">Copyright &copy; 2021. {{ env('APP_NAME') }}. All Rights Reserved</p>
                </div>
                <div class="col-lg-4 col-4">
                    <span class="social-icons float-right">
                        <i class="fab fa-facebook-square fa-lg"></i>
                        <i class="fab fa-instagram-square fa-lg"></i>
                        <i class="fab fa-twitter-square fa-lg"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection