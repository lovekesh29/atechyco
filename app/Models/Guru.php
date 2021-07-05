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

    public function country()
    {
        return $this->belongsTo(Countries::class, 'location', 'countryCode');
    }
    public function securityQuestionDetail()
    {
        return $this->belongsTo(SecurityQuestion::class, 'securityQuestion');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\GuruVerifyEmail);
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\GuruForgotPassword($token));
    }
}
