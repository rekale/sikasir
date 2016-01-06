<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\User\User;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'outlet_id',
        'user_id',
        'note',
        'total',
    ];
    
    /**
     * 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks()
    {
        return $this->belongsToMany(Stock::class);
    }
    
    public function void()
    {
        return $this->belongsToMany(User::class, 'void_orders')->withPivot(['note']);
    }
}
