<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    //
    protected $fillable = [
          
        'bill_id','description', 'quantity', 'unit_value','total_value'
    ];
}
