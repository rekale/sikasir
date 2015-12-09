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
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }
    
    public function cashier()
    {
        return $this->hasOne(Cashier::class);
    }
    
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * change current to owner
     * 
     * @return Sikasir\V1\User\Owner
     */
    public function toOwner()
    {
        if ($this->is('owner')) {
            return $this->owner;
        }
        else if ($this->is('staff')) {
            $this->employee->owner;
        }
        else if ($this->is('cashier')) {
            $this->cashier->owner;
        }
        else {
            abort(403);
        }
    }

}
