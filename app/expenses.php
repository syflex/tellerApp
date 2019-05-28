<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expenses extends Model
{
    protected $fillable = [
        'company_id','name','amount','description','expenses_by'
    ];
}
