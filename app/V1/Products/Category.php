<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\Company;

class Category extends Model
{
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id','name'];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
