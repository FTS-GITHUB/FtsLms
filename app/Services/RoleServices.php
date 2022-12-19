<?php

namespace App\Services;

use App\Services\BaseServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleServices extends BaseServices
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
    public function search()
    {
        $model = $this->model;
        return $this->model->paginate(10);
    }
    public function getPermission()
    {
        $permission = Permission::get();
        return $permission;
    }
    public function store($request)
    {
        try {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            return $role;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function show($role)
    {
        try {
            $id = $role->id;
            $role = Role::find($id);
            $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get();
            return $rolePermissions;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function edit($role)
    {
        try {
            $id = $role->id;
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
            $permission = [$role, $permission, $rolePermissions];
            return $permission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update($role, $request)
    {
        try {

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteRole($role)
    {
        try {
            DB::table("roles")->where('id',$role->id)->delete();
            return ;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
