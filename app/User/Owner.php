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
    protected $table = 'owners';
    
    protected $with = ['user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['full_name', 'business_name', 'phone', 'address', 'icon', 'active',];
    
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
    
    /**
     * owner has many outlets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlets()
    {
       return $this->hasMany(\Sikasir\Outlets\Outlet::class, 'owner_id'); 
    }
    
    public function employees()
    {
        return $this->hasManyThrough(\Sikasir\User\Employee::class, \Sikasir\Outlets\Outlet::class, 'owner_id', 'outlet_id');
    }
    
     /**
     * owner has one app
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function app()
    {
       return $this->hasOne(App::class, 'owner_id'); 
    }
    
    public function categories()
    {
        return $this->hasMany(\Sikasir\Products\Category::class, 'owner_id');
    }

}
