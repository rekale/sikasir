<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Stocks\StockDetail;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'supplier_id',
        'outlet_id',
        'po_number',
        'note',
        'input_at',
    ];
    
    public function items()
    {
        return $this->belongsToMany(StockDetail::class)->withPivot('total');
    }
}
