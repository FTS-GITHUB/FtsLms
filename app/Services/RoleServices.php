<?php

namespace App\Services;

use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleServices extends BaseServices
{
    use Jsonify;

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function search()
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function getPermission()
    {
        DB::beginTransaction();
        try {
            $permission = Permission::get();
            DB::commit();

            return self::jsonSuccess(message: '', data: $permission);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            DB::commit();

            return self::jsonSuccess(message: '', data: $role);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($role)
    {
        DB::beginTransaction();
        try {
            $id = $role->id;
            $role = Role::find($id);
            $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', $id)
                ->get();
            DB::commit();

            return self::jsonSuccess(message: '', data: $rolePermissions);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function edit($role)
    {
        DB::beginTransaction();
        try {
            $id = $role->id;
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
            $permission = [$role, $permission, $rolePermissions];
            DB::commit();

            return self::jsonSuccess(message: '', data: $rolePermissions);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
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
        DB::beginTransaction();
        try {
            $rolePermissions = DB::table('roles')->where('id', $role->id)->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Permissions deleted', data: $rolePermissions);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
