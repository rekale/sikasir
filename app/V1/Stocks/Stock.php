<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;

class Stock extends Model
{
    protected $fillable = [
      'outlet_id',
      'variant_id',
      'total',
    ];
    
    
    protected $with = ['variant.product.category', 'stockentries'];

    
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }
    
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}
