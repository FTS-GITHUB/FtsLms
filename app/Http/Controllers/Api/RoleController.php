<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use Jsonify;
    private $roleServices;
    public function __construct(RoleServices $roleServices)
    {
        parent::__permissions('roles');
        $this->roleServices = $roleServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $roles = $this->roleServices->search($request->all());
            return self::jsonSuccess(RoleResource::collection($roles), message: 'Role Retrived successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {
        try {
            $permission = $this->roleServices->getPermission($request);
            return self::jsonSuccess(RoleResource::collection($permission), message: 'Role Retrived successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleServices->store($request);
            return self::jsonSuccess(data: $role, message: 'Role Create successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return self::jsonSuccess(data: $role->load('permissions'), message: 'Role retrived successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        try {
            $permission = $this->roleServices->edit($role);
            return self::jsonSuccess(data: $permission, message: 'Role retrived successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        try {
            $role->update($request->safe()->only('name'));

            $role->syncPermissions($request->safe()->only('permissions'));
            return self::jsonSuccess(data: $role, message: 'Role updated successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        try {
            $this->roleServices->deleteRole($role);
            return self::jsonSuccess(data: '', message: 'Role deleted successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
        //
    }
}
