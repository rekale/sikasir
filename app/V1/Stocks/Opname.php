<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Products\Product;

class Opname extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'note',
        'input_at',
        'status',
    ];
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('total');
    }
}
