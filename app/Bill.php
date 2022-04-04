<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Bill extends Model
{
    use Database;
    //
    protected $fillable = [
          
        'sender_name', 'sender_nit', 'customer_name','customer_nit','value','iva','value_with_iva','amount_to_pay'
    ];

    public  function saveOrUpdate (array $data) {

        $bill = $this->persist( Bill::class, $data);
       return $bill;

    }
}
