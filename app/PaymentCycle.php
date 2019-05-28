<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCycle extends Model
{
    //
    public function cycle_data()
    {
        return $this->hasMany('App\PaymentCycleData');
    }
}
