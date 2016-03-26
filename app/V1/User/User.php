<?php

namespace Sikasir\V1\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Sikasir\V1\Outlets\Outlet;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Authorizable, HasRolesAndAbilities;

    /**
     * The database table used by the model.
    *
     * @var string
     */
    protected $table = 'users';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name', 
        'email', 
        'password', 
        'title', 
        'gender',
        'address', 
        'phone',  
        'icon',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];
    
    public function setPasswordAttribute($value)
    {
    	$this->attributes['password'] = bcrypt($value);
    }
    
    public function scopeReport($query, $dateRange, $outletId = null)
    {
        $query->selectRaw(
            'users.* ,'
            . 'count(orders.id) as total, '
            . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
        )
        ->join('orders', 'users.id', '=', 'orders.user_id')
        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
        ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
        ->whereBetween('orders.created_at', $dateRange)
        ->groupBy('users.id');
        
        if(! is_null($outletId)) {
            $query->where('orders.outlet_id', '=', $outletId);
        }
    }
    
    public function outlets()
    {
        return $this->belongsToMany(Outlet::class);
    }
    
    /**
     * get current user's owner id
     * 
     * @return Sikasir\V1\User\Company
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }
    
}
