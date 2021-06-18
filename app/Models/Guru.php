<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstName',
        'lastName',
        'location',
        'phoneNo',
        'email',
        'password',
        'securityQuestion',
        'securityAnswer',
        'gender',
        'age',
        'imgPath',
        'status',
        'dialCode'
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\GuruVerifyEmail);
    }
}
