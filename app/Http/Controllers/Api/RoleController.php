<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $roles = Role::query()->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        })
            ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Role::create($data);

        return $this->response->withNoContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->response->item(Role::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Role::findOrFail($id)->update($request->all());

        return $this->response->withNoContent();
    }

    /**
     * Update Role Permissions
     *
     * @param \Illuminate\Http\Request       $request
     * @param \Spatie\Permission\Models\Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $role->permissions()->sync($request->get('permissions'));

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return $this->response->withNoContent();
    }
}
