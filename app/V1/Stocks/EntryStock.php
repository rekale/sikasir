<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\Stock;

class EntryStock extends Model
{
    protected $table = 'entry_stock';
    
    protected $fillable = [
        'entry_id',
        'stock_id',
        'total',
    ];
    
}
