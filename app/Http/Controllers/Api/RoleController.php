<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\Roles\StoreRoleRequest;
use App\Http\Requests\Permissions\Roles\UpdateRoleRequest;
use App\Http\Resources\Collections\Permissions\RolesCollection;
use App\Http\Resources\Permissions\RoleResource;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use Jsonify;

    public function __construct()
    {
        parent::__permissions('roles');
    }

    public function index()
    {
        $data = (new RolesCollection(Role::with('permissions')->get()));

        return self::jsonSuccess(message: 'Roles retreived successfully.', data: $data, code: 200);
    }

    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create($request->safe()->only('name'));

            if ($request->safe()->has('permissions')) {
                $role->givePermissionTo($request->safe()->only('permissions'));
            }
            DB::commit();

            return self::jsonSuccess(message: 'Role saved successfully!', data: $role);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Role $role)
    {
        return self::jsonSuccess(message: 'Roles retreived successfully.', data: new RoleResource($role->load('permissions')));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role->update($request->safe()->only('name'));

            if ($request->safe()->has('permissions')) {
                $role->syncPermissions($request->safe()->only('permissions'));
            }

            return self::jsonSuccess(data: $role->load('permissions'), message: 'Role updated successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        $role->syncPermissions();

        $role->delete();

        return self::jsonSuccess(message: 'Role deleted successfully.');
    }
}
