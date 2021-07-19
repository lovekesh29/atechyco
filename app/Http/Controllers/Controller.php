<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Subscription;
use App\Models\UserSubscriptions;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkUserSubscriptionValidity($userId){
        $userSubscription = UserSubscriptions::where('userId', $userId)->latest()->first();

        if($userSubscription == null){
            return false;
        }

        $subscription = Subscription::findOrFail($userSubscription->subscriptionId);
        $subcriptionBuyDate = Carbon::parse($userSubscription->created_at);
        $now = Carbon::now();

        $subscriptionPlanDiffrence = $subcriptionBuyDate->diffInSeconds($now);

        $subscriptionValidityInSeconds = $subscription->validity*86400; //86400 seconds in one day and validity is in days

        if($subscriptionValidityInSeconds > $subscriptionPlanDiffrence)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function getVideoId($videoUrl){
        $videoUrlExploded = explode('/', $videoUrl);
        return $videoUrlExploded[2];
    }
}
