<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\Outlets\Outlet;

class Stock extends Model
{
    protected $fillable = [
      'outlet_id',
      'variant_id',
      'total',
    ];
    
    
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    
    public function entries()
    {
        return $this->belongsToMany(StockEntry::class, 'entry_stock', 'stock_id', 'entry_id')
                ->withPivot('total');
    }
    
    public function outs()
    {
        return $this->belongsToMany(StockOut::class, 'out_stock', 'stock_id', 'out_id')
                ->withPivot('total');
    }
}
