<?php

namespace App\Traits\ProviderRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait HasRoleAndPermission
{
    /**
     * Property for caching roles.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $roles;

    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $permissions;

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('model.provider_roles.provider_role.model.model'),'provider_user_provider_role')->withTimestamps();
    }

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles()
    {
        return (!$this->roles) ? $this->roles = $this->roles()->get() : $this->roles;
    }

    /**
     * Check if the user has at least one role.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isOne($role)
    {

        foreach ($this->getArrayFrom($role) as $role) {

            if ($this->hasRole($role)) {
                return true;
            }

        }

        return false;
    }

    /**
     * Check if the user has at least one role.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isA($role)
    {
        return $this->hasRole($role);
    }

    /**
     * Check if the user has at least one role.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isAn($role)
    {
        return $this->hasRole($role);
    }

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isAll($role)
    {

        foreach ($this->getArrayFrom($role) as $role) {

            if (!$this->hasRole($role)) {
                return false;
            }

        }

        return true;
    }

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getRoles()->contains(function ($value, $key) use ($role) {
            return $role == $value->id || str_is($role, $value->slug);
        });
    }

    /**
     * Attach role to a user.
     *
     * @param int|\App\Models\Role $role
     * @return null|bool
     */
    public function attachRole($role)
    {
        return (!$this->getRoles()->contains($role)) ? $this->roles()->attach($role) : true;
    }

    /**
     * Detach role from a user.
     *
     * @param int|\App\Models\Role $role
     * @return int
     */
    public function detachRole($role)
    {
        $this->roles = null;

        return $this->roles()->detach($role);
    }

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles()
    {
        $this->roles = null;

        return $this->roles()->detach();
    }

    /**
     * Get role level of a user.
     *
     * @return int
     */
    public function level()
    {
        return ($role = $this->getRoles()->sortByDesc('level')->first()) ? $role->level : 0;
    }

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions()
    {
        $permissionModel = app(config('model.provider_roles.provider_permission.model.model'));

        if (!$permissionModel instanceof Model) {
            throw new InvalidArgumentException('[model.provider_roles.provider_permission.model.model] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        return $permissionModel::select(['provider_permissions.slug', 'provider_permissions.name'])
            ->join('provider_permission_provider_role', 'provider_permission_provider_role.provider_permission_id', '=', 'provider_permissions.id')
            ->join('provider_roles', 'provider_roles.id', '=', 'provider_permission_provider_role.provider_role_id')
            ->whereIn('provider_roles.id', $this->getRoles()->pluck('id')->toArray())
            ->orWhere('provider_roles.level', '<', $this->level());
            //->groupBy(['provider_permissions.slug']);
    }

    public function menus($parent_id = 0)
    {
        $permissionModel = app(config('model.provider_roles.provider_permission.model.model'));

        if (!$permissionModel instanceof Model) {
            throw new InvalidArgumentException('[model.provider_roles.provider_permission.model.model] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        if($this->isSuperuser())
        {
            return $permissionModel::where('parent_id', $parent_id)->where('is_menu', 1)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        }
        return $permissionModel::select(['provider_permissions.slug', 'provider_permissions.name','provider_permissions.icon'])
            ->join('provider_permission_provider_role', 'provider_permission_provider_role.provider_permission_id', '=', 'provider_permissions.id')
            ->join('provider_roles', 'provider_roles.id', '=', 'provider_permission_provider_role.provider_role_id')
            ->where('is_menu', 1)
            ->where('parent_id', $parent_id)
            ->whereIn('provider_roles.id', $this->getRoles()->pluck('id')->toArray())
            ->orWhere('provider_roles.level', '<', $this->level())
            //->groupBy(['provider_permissions.slug'])
            ->get();
    }

    /**
     * User belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions()
    {
        return null;
        return $this->belongsToMany(config('model.provider_roles.provider_permission.model.model'))->withTimestamps();
    }

    /**
     * Get all permissions as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions()
    {
        return (!$this->permissions) ? $this->permissions = $this->rolePermissions()->get() : $this->permissions;
        return (!$this->permissions) ? $this->permissions = $this->rolePermissions()->get()->merge($this->userPermissions()->get()) : $this->permissions;
    }

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @param bool $all
     * @return bool
     */
    public function canDo($permission, $all = false)
    {

        if ($this->isPretendEnabled()) {
            return $this->pretend('can');
        }

        if ($this->isSuperuser()) {
            return true;
        }

        return $this->{$this->getMethodName('can', $all)}
        ($permission);
    }
    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @return bool
     */
    public function checkPermission($permission)
    {

        if ($this->isPretendEnabled()) {
            return $this->pretend('can');
        }

        if ($this->isSuperuser()) {
            return true;
        }

        return $this->canOne($permission);
    }

    /**
     * Check if the user has at least one permission.
     *
     * @param int|string|array $permission
     * @return bool
     */
    public function canOne($permission)
    {

        foreach ($this->getArrayFrom($permission) as $permission) {

            if ($this->hasPermission($permission)) {
                return true;
            }

        }

        return false;
    }

    /**
     * Check if the user has all permissions.
     *
     * @param int|string|array $permission
     * @return bool
     */
    public function canAll($permission)
    {

        foreach ($this->getArrayFrom($permission) as $permission) {

            if (!$this->hasPermission($permission)) {
                return false;
            }

        }

        return true;
    }

    /**
     * Check if the user has a permission.
     *
     * @param int|string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->getPermissions()->contains(function ($value, $key) use ($permission) {
            return $permission == $value->id || str_is($permission, $value->slug);
        });
    }

    /**
     * Check if the user is allowed to manipulate with entity.
     *
     * @param string $providedPermission
     * @param \Illuminate\Database\Eloquent\Model $entity
     * @param bool $owner
     * @param string $ownerIdColumn
     * @return bool
     */
    public function allowed($providedPermission, Model $entity, $owner = true, $ownerIdColumn = 'user_id', $ownerTypeColumn = 'user_type')
    {

        if ($this->isPretendEnabled()) {
            return $this->pretend('allowed');
        }

        if ($this->isSuperuser()) {
            return true;
        }

        if (
            $owner === true
            && ($entity->{$ownerIdColumn} == user_id() && $entity->{$ownerTypeColumn} == user_type())
        ) {
            return true;
        }

        return $this->isAllowed($providedPermission, $entity);
    }

    /**
     * Check if the user is allowed to manipulate with provided entity.
     *
     * @param string $providedPermission
     * @param \Illuminate\Database\Eloquent\Model $entity
     * @return bool
     */
    protected function isAllowed($providedPermission, Model $entity)
    {

        foreach ($this->getPermissions() as $permission) {

            if ($permission->model != '' && get_class($entity) == $permission->model
                && ($permission->id == $providedPermission || $permission->slug === $providedPermission)
            ) {
                return true;
            }

        }

        return false;
    }

    /**
     * Attach permission to a user.
     *
     * @param int|\App\Models\Permission $permission
     * @return null|bool
     */
    public function attachPermission($permission)
    {
        return (!$this->getPermissions()->contains($permission)) ? $this->userPermissions()->attach($permission) : true;
    }

    /**
     * Detach permission from a user.
     *
     * @param int|\App\Models\Permission $permission
     * @return int
     */
    public function detachPermission($permission)
    {
        $this->permissions = null;

        return $this->userPermissions()->detach($permission);
    }

    /**
     * Detach all permissions from a user.
     *
     * @return int
     */
    public function detachAllPermissions()
    {
        $this->permissions = null;

        return $this->userPermissions()->detach();
    }

    /**
     * Check if pretend option is enabled.
     *
     * @return bool
     */
    private function isPretendEnabled()
    {
        return (bool) config('model.roles.pretend.enabled', false);
    }

    /**
     * Allows to pretend or simulate package behavior.
     *
     * @param string $option
     * @return bool
     */
    private function pretend($option)
    {
        return (bool) config('model.roles.pretend.options.' . $option);
    }

    /**
     * Get method name.
     *
     * @param string $methodName
     * @param bool $all
     * @return string
     */
    private function getMethodName($methodName, $all)
    {
        return ((bool) $all) ? $methodName . 'All' : $methodName . 'One';
    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     * @return array
     */
    private function getArrayFrom($argument)
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', $argument) : $argument;
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'is')) {
            return $this->hasRole(snake_case(substr($method, 2), config('model.roles.separator', '.')));
        } elseif (starts_with($method, 'can')) {
            return $this->canDo(snake_case(substr($method, 3), config('model.roles.separator', '.')));
        } elseif (starts_with($method, 'allowed')) {
            return $this->allowed(snake_case(substr($method, 7), config('model.roles.separator', '.')), $parameters[0], (isset($parameters[1])) ? $parameters[1] : true, (isset($parameters[2])) ? $parameters[2] : 'user_id');
        }
        return parent::__call($method, $parameters);
    }

}
