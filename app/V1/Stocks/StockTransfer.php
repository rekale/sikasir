<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $fillable = [
        'source_outlet_id',
        'destination_outlet_id',
        'variant_id',
        'note',
        'total',
    ];
}
