<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentWallet extends Model
{
    protected $fillable = [
       'user_id','wallet'
    ];

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
