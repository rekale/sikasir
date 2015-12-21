<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;

class StockDetail extends Model
{
    protected $fillable = [
      'variant_id',
      'total',
    ];
    
    
    protected $with = ['variant.product.category', 'stockentries'];


    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    
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
