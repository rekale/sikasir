<?php

namespace Sikasir\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DCN\RBAC\Traits\HasRoleAndPermission;
use DCN\RBAC\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    HasRoleAndPermissionContract
{
    use Authenticatable, CanResetPassword, HasRoleAndPermission;

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
    
    public function userable()
    {
        return $this->morphTo();
    }
    
    public function isOwner()
    {
        return $this->userable instanceof Owner;
    }
    
    public function isEmployee()
    {
        return $this->userable instanceof Employee;
    }
    

    public function allowed($providedPermission, Model $entity, $owner = true, $ownerColumn = 'user_id') {
        
    }

    public function attachPermission($permission, $granted = TRUE) {
        
    }

    public function attachRole($role, $granted = TRUE) {
        
    }

    public function detachAllPermissions() {
        
    }

    public function detachAllRoles() {
        
    }

    public function detachPermission($permission) {
        
    }

    public function detachRole($role) {
        
    }

    public function getPermissions() {
        
    }

    public function getRoles() {
        
    }

    public function is($role, $all = false) {
        
    }

    public function rolePermissions() {
        
    }

    public function roles() {
        
    }

    public function userPermissions() {
        
    }

}
