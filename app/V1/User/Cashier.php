<?php

namespace Sikasir\V1\User;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cashiers';

    protected $with = ['user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender','address', 'phone', 'icon',
    ];

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

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * employee can work in many outlet, *except kasir
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outlets()
    {
        return $this->belongsTo(\Sikasir\V1\Outlets\Outlet::class);
    }
}
