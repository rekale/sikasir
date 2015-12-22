<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\Stock;

class StockOut extends Model
{
    
    protected $table = 'outs';
    
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
    
    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'out_stock', 'out_id', 'stock_id')
                ->withPivot('total');
    }
    
}
