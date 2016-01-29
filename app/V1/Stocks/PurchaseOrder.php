<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Suppliers\Supplier;
use Sikasir\V1\Products\Product;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'supplier_id',
        'outlet_id',
        'po_number',
        'note',
        'input_at',
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('total');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
