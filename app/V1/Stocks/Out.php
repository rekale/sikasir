<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\StockDetail;

class Out extends Model
{
    
    protected $fillable = [
        'user_id',
        'outlet_id',
        'note',
        'input_at',
    ];
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function items()
    {
        return $this->belongsToMany(StockDetail::class, 'out_stockdetail', 'out_id', 'stock_detail_id')
                ->withPivot('total');
    }
    
}
