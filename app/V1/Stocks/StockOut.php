<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Products\Variant;

class StockOut extends Model
{
    protected $fillable = [
        'user_id',
        'variant_id',
        'note',
        'total',
        'input_at',  
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    
}
