<?php

namespace App\Transformers;

use Spatie\Permission\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'            => $role->id,
            'name'          => $role->name,
            'guard_name'    => $role->guard_name,
            'created_at'    => $role->created_at->toDateTimeString(),
        ];
    }
}
