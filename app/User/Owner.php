<?php

namespace Sikasir\User;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['full_name', 'business_name', 'phone', 'address', 'active'];
    
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
     * owner has many employees
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'member_id');
    }

}
