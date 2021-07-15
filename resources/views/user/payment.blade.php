@extends('layouts.app')
@include('layouts.header')
@section('home')
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
                                    <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link active show"> <i class="fab fa-paypal mr-2"></i> Razorpay </a> </li>
                                </ul>
                            </div> <!-- End -->
                            <!-- Credit card form content -->
                            <div class="tab-content">
                                
                            <!-- Paypal info -->
                            <div id="paypal" class="tab-pane fade pt-3 active show">
                                <button id="rzp-button1">Pay with Razorpay</button>
                                <form name='razorpayform' action="{{ url('payment-notification') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                                    <input type="hidden" name="razorpay_orderId"  id="razorpay_orderId" >
                                </form>
                            </div> <!-- End -->
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    // Checkout details as a json
    var options =  <?php echo $razorJson; ?>;
    
    /**
    * The entire list of checkout fields is available at
    * https://docs.razorpay.com/docs/checkout-form#checkout-fields
    */
    options.handler = function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.getElementById('razorpay_orderId').value = response.razorpay_order_id;
        document.razorpayform.submit();
    };
    

    
    
    var rzp = new Razorpay(options);
    
    document.getElementById('rzp-button1').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
    </script>
@endsection
@include('layouts.footer')