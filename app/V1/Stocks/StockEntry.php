<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Stocks\Stock;

class StockEntry extends Model
{
    protected $table = 'entries';
    
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
        return $this->belongsToMany(Stock::class, 'entry_stock', 'entry_id')
                ->withPivot('total');
    }
}
