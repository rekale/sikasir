<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;

class Opname extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'note',
        'input_at',
        'status',
    ];
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function items()
    {
        return $this->belongsToMany(StockDetail::class, 'opname_stockdetail', 'opname_id', 'stock_detail_id')
                ->withPivot('total');
    }
}
