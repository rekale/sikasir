<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\Stocks\StockTransfer;

class Stock extends Model
{
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function details()
    {
        return $this->hasMany(StockDetail::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function entries()
    {
        return $this->hasMany(StockEntry::class);
    }
    
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function outs()
    {
        return $this->hasMany(StockOut::class);
    }
    
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function transfers()
    {
        return $this->hasMany(StockTransfer::class);
    }
}
