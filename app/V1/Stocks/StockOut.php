<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
      'user_id',
      'variant_id',
      'note',
      'total',  
    ];
}
