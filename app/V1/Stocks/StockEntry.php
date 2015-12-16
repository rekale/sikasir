<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    protected $tables = 'stock_ins';
            
    protected $fillable = [
        'user_id',
        'variant_id',
        'note',
        'total',
    ];
}
