<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCycleData extends Model
{
    protected $fillable = [
        'company_id','payment_cycle_id','day','date','status'
    ];
    
    public function cycle_data()
    {
        return $this->belongsTo('App\PaymentCycle');
    }
}
