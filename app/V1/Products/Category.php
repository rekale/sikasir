<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public function owner()
    {
        return $this->belongsTo(\Sikasir\V1\User\Owner::class, 'owner_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
}
