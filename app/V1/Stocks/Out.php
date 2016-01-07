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
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->belongsToMany(StockDetail::class, 'entry_stockdetail', 'entry_id', 'stock_detail_id')
                ->withPivot('total');
    }
    
}
