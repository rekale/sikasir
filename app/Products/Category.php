<?php

namespace Sikasir\Products;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'product_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public function owner()
    {
        return $this->belongsTo(\Sikasir\User\Owner::class, 'owner_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
    
}
