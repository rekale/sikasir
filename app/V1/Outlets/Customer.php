<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Orders\Order;

class Customer extends Model
{
    protected $fillable = [
        'company_id',
        'name', 
        'email', 
        'sex', 
        'phone', 
        'address', 
        'city', 
        'pos_code'
    ];
    
    
    protected $hidden = ['created_at', 'updated_at'];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
