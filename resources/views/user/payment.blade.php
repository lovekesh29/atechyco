@extends('layouts.app')
@include('layouts.header')
@section('home')
<script
    src="https://www.paypal.com/sdk/js?client-id=">  
  </script>
    <section class="trending-courses main-page-section pricing-section">
        <div class="container py-5">
            <!-- For demo purpose -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-6">Payment Forms</h1>
                </div>
            </div> <!-- End -->
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="price-card payment-form">
                        <div class="card-header payment-form-header">
                            <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                                <!-- Credit card form tabs -->
                                <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                    <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link active show"> <i class="fab fa-paypal mr-2"></i> Paypal </a> </li>
                                </ul>
                            </div> <!-- End -->
                            <!-- Credit card form content -->
                            <div class="tab-content">
                                
                            <!-- Paypal info -->
                            <div id="paypal" class="tab-pane fade pt-3 active show">
                                <form role="form" onsubmit="event.preventDefault()">
                                    <div class="form-group"> 
                                        <label for="username"><h6>Card Owner</h6></label> <input type="text" name="username" placeholder="Card Owner Name" required class="form-control "> 
                                    </div>
                                    <div class="form-group"> 
                                        <label for="username"><h6>Card Owner</h6></label> <input type="text" name="username" placeholder="Card Owner Name" required class="form-control "> 
                                    </div>
                                    <button type="button" class="btn btn-primary btn-mid"> Confirm Payment </button>
                                </form>
                            </div> <!-- End -->
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@include('layouts.footer')