<?php

namespace App\Traits\PaymentRoles;

trait RoleHasRelations
{
    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('model.payment_roles.payment_permission.model.model'))->withTimestamps();
    }

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.payment_users.model'))->withTimestamps();
    }

    /**
     * Attach permission to a role.
     *
     * @param int|\App\Models\Permission $permission
     * @return int|bool
     */
    public function attachPermission($permission)
    {
        return (!$this->permissions()->get()->contains($permission)) ? $this->permissions()->attach($permission) : true;
    }

    /**
     * Detach permission from a role.
     *
     * @param int|\App\Models\Permission $permission
     * @return int
     */
    public function detachPermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    /**
     * Detach all permissions.
     *
     * @return int
     */
    public function detachAllPermissions()
    {
        return $this->permissions()->detach();
    }
    
    /**
     * Detach all permissions.
     *
     * @return int
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->get()->contains(function ($value, $key) use ($permission) {
            return $permission == $value->id || str_is($permission, $value->slug);
        });
    }
    
}
