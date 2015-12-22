<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\Stock;

class StockEntry extends Model
{
    
    protected $fillable = [
        'user_id',
        'stock_id',
        'note',
        'total',
        'input_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
