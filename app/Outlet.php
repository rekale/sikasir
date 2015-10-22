<?php

namespace Sikasir;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'outlets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'province', 'city', 'pos_code', 'phone1', 'phone2', 'icon'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    
    /**
     * outlet belongs to one owner
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User\Owner::class, 'owner_id');
    }
    
    

    
}
