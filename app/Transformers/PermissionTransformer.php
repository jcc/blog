<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id'                => $permission->id,
            'name'              => $permission->name,
            'label'             => trans('permissions.' . $permission->name)
        ];
    }
}
