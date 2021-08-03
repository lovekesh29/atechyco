<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $fillable = ['paymentId', 'amount', 'currency', 'paymentMethod'];

    public function getUser(){
        return $this->belongsToMany(User::class, 'user_subscriptions', 'paymentId', 'userId');
    }
}
