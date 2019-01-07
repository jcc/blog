<?php

namespace App\Transformers;

use Spatie\Permission\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    protected $availableIncludes  = [
        'permissions'
    ];

    public function transform(Role $role)
    {
        return [
            'id'            => $role->id,
            'name'          => $role->name,
            'guard_name'    => $role->guard_name,
            'permission_ids'=> $role->permissions->pluck('id'),
            'created_at'    => $role->created_at->toDateTimeString(),
        ];
    }

    /**
     * Include Category
     *
     * @param Role $role
     * @return \League\Fractal\Resource\Collection
     */
    public function includePermissions(Role $role)
    {
        if ($permissions = $role->permissions) {
            return $this->collection($permissions, new PermissionTransformer);
        }
    }
}
