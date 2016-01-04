<?php

namespace Sikasir\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'outlet_id',
        'user_id',
        'total',
    ];
}
