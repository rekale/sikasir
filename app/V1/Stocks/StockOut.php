<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\StockDetail;

class StockOut extends Model
{
    protected $fillable = [
        'user_id',
        'stock_detail_id',
        'note',
        'total',
        'input_at',  
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function stockDetail()
    {
        return $this->belongsTo(StockDetail::class);
    }
    
}
