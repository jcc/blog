<?php

namespace App\Http\Controllers\Api;


use Spatie\Permission\Models\Permission;

class PermissionsController extends ApiController
{
    /**
     * Get all permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all();

        return $this->response->collection($permissions);
    }
}
