<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function securityQuestionDetail()
    {
        return $this->belongsTo(SecurityQuestion::class, 'securityQuestion');
    }
    public function country()
    {
        return $this->belongsTo(Countries::class, 'location', 'countryCode');
    }
    public function referer()
    {
        return $this->belongsTo(User::class, 'referedBy');
    }
    public function commisonBalance()
    {
        return $this->hasMany(UserWallet::class, 'userId');
    }
}
