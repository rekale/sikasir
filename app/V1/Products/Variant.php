<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'product_variants';
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'price', 'unit'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
