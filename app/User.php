<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','name','address','delivery','nok_name','nok_phone','nok_address','plan_id', 'email', 'password','phone','avatar','account_number','wallet','referrer_code',
        'referrer_id','is_active','is_admin','is_sub_admin','is_accountant','is_manager','manager_id',
        'is_officer','officer_id','zone_id','registrar_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'officer_id');
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function payment_wallet()
    {
        return $this->hasOne('App\PaymentWallet');
    }

    public function latest_payment_token()
    {
    return $this->hasOne('App\PaymentToken')->latest();
    }
}
