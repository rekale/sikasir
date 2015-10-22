<?php

namespace Sikasir\Finances;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['total', 'note'];
    
     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['outlet_id',];
    
    public function outlet()
    {
        return $this->belongsTo(\Sikasir\Outlet::class, 'outlet_id');
    }
}
