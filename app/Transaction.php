<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'transaction_id', 'transaction_type','amount','transaction_charges',
        'balance_befor','balance_after','teller_id','description'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function staff()
    {
        return $this->belongsTo('App\User', 'teller_id');
    }
}
