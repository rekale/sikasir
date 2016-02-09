<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\User\User;

class Void extends Model
{
    
    protected $fillable = [
        'user_id',
        'note',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
