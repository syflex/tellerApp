<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentToken extends Model
{
    protected $fillable = [
        'company_id','user_id','token_id','token_type','amount','balance_befor','balance_after','staff_id','description'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function staff()
    {
        return $this->belongsTo('App\User', 'staff_id');
    }
}
