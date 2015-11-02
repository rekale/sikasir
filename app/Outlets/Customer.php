<?php

namespace Sikasir\Outlets;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    
    protected $fillable = ['name', 'email', 'title', 'sex', 'phone', 'address', 'city', 'pos_code'];
    
    
    protected $hidden = ['created_at', 'updated_at'];
}
