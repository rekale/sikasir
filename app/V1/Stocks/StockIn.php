<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'user_id',
        'variant_id',
        'note',
        'total',
    ];
}
