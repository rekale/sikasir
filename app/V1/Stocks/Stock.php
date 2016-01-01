<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
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
        return $this->belongsToMany(Entry::class, 'entry_stock', 'stock_id', 'entry_id')
                ->withPivot('total');
    }
    
    public function outs()
    {
        return $this->belongsToMany(Out::class, 'out_stock', 'stock_id', 'out_id')
                ->withPivot('total');
    }
}
