@extends('layouts.app')
@include('layouts.header')
@section('home')
    <section class="trending-courses main-page-section pricing-section">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="section-title text-center title-ex1">
                        <h2>Pricing Tables</h2>
                        <p>Inventore cillum soluta inceptos eos platea, soluta class laoreet repellendus imperdiet optio.</p>
                    </div>
                </div>
            </div>
            <!-- Pricing Table starts -->
            <div class="row">
                <div class="col-md-4">
                    @php
                        $i=0;
                    @endphp
                    @foreach ($subscriptionPackage as $subscriptionPackage)
                    <div class="price-card {{ ($i%2 == 0) ? 'featured' : '' }}">
                        <h2>{{ $subscriptionPackage->name }}</h2>
                        <p>The standard version</p>
                        <p class="price"><span>{{ $subscriptionPackage->price }}</span>/ Month</p>
                        {!! $subscriptionPackage->description !!}
                        <a href="{{ url('/payment/'.Crypt::encryptString($subscriptionPackage->id)) }}" class="btn btn-primary btn-mid">Buy Now</a>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@include('layouts.footer')