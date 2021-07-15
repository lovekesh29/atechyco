<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Subscription;
use App\Models\PaymentDetails;
use App\Models\UserSubscriptions;
use Razorpay\Api\Api;
use Session;
use Exception;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    private function getApi(){
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        return $api;
    }
    private function getRazorPayJsonData($subscriptionId, $subscriptionPrice, $subscriptionName, $razorpayOrderId){
        $data = [
            "key"               => env('RAZORPAY_KEY'),
            "amount"            => $subscriptionPrice*100,
            "name"              => $subscriptionName,
            "image"             => "https://cdn.razorpay.com/logos/FFATTsJeURNMxx_medium.png",
            "prefill"           => [
            "name"              => Auth::user()->firstName,
            "email"             => Auth::user()->email,
            "contact"           => Auth::user()->phoneNo,
            ],
            "notes"             => [
            "userId"           => Auth::id(),
            "subscriptionId" => 1,
            ],
            "order_id"          => $razorpayOrderId,
        ];

        return json_encode($data);
    }
    public function viewPaymentPage($encryptedSubscriptionId){
        $subscriptionId = Crypt::decryptString($encryptedSubscriptionId);
        $subscriptionDetails = Subscription::find($subscriptionId);

        $orderData = [
            'amount'          => $subscriptionDetails->price*100, // 39900 rupees in paise
            'currency'        => 'INR'
        ];

        $api = self::getApi();
        $razorpayOrder = $api->order->create($orderData);
        session(['razorpayOrderId' => $razorpayOrder['id']]);

        $razorJson = self::getRazorPayJsonData($subscriptionId, $subscriptionDetails->price, $subscriptionDetails->name, $razorpayOrder['id']);
        return view('user.payment', ['razorpayOrder' => $razorpayOrder, 'razorJson' => $razorJson]);
    }
    public function paymentNotification(Request $request){
        $success = true;

        $error = "Payment Failed";

        if (empty($request->razorpay_payment_id) === false)
        {
            $api = self::getApi();

            //verifying the signature
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => session('razorpayOrderId'),
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                );
                session()->forget('razorpayOrderId');
                session()->save();

                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        $paymentDetails = $api->payment->fetch($request->razorpay_payment_id);
        if ($success === true)
        {
            $paymentEntry = PaymentDetails::create([
                'paymentId' => $paymentDetails['id'],
                'amount' => $paymentDetails['amount']/100,
                'currency' => $paymentDetails['currency'],
                'paymentMethod' => $paymentDetails['method']
            ]);
            UserSubscriptions::create([
                'userId' => $paymentDetails['notes']['userId'],
                'subscriptionId' => $paymentDetails['notes']['subscriptionId'],
                'paymentId' => $paymentEntry->id
            ]);

            return redirect('/dashboard')->with('status', 'Payment Has been done successfully');
        }
        else
        {
            return redirect('/subscriptions')->with('error', $error);
        }
    }
}
