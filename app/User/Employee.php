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
    protected $table = 'employees';
    
    protected $with = ['user']; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'phone', 'void_access', 'icon'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
    
    
}
