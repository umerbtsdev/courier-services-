<?php

namespace App\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use App\Permission\Contracts\Role as RoleContract;
use App\Permission\Exceptions\RoleDoesNotExist;
use App\Permission\Traits\HasPermissions;
use App\Permission\Traits\RefreshesPermissionCache;

class Role extends Model implements RoleContract
{
    use HasPermissions;
    use RefreshesPermissionCache;

   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-permission.table_names.roles'));
    }

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.permission'),
            config('laravel-permission.table_names.role_has_permissions')
        );
    }

    /**
     * A role may be assigned to various users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            config('auth.model') ?: config('auth.providers.users.model'),
            config('laravel-permission.table_names.user_has_roles')
        );
    }

    /**
     * Find a role by its name.
     *
     * @param string $name
     *
     * @throws RoleDoesNotExist
     *
     * @return Role
     */
    public static function findByName($name)
    {
        $role = static::where('name', $name)->first();

        if (!$role) {
            throw new RoleDoesNotExist();
        }

        return $role;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission);
        }

        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|
     *
     * @return bool
     */
    public function hasPermissionRoleWise($permission, $roleid)
    {
        if (is_string($permission)) {
            //$permission = app(Permission::class)->findByName($permission);

            $permission = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('permissions.name', $permission)
                ->where('role_has_permissions.role_id', $roleid)
                ->first();
            if($permission === null)
            {
                return false;
            }
            else
            {
                return true;
            }
        }


        return $this->permissions->contains('id', $permission->id);
    }
}
