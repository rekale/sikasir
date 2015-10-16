<?php

namespace Sikasir\User;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'operators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'phone', 'city', 'void_access', 'icon'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->morphOne('User', 'userable');
    }
    
    /**
     * an employee working for one boss/chief
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'member_id');
    }
    
}
