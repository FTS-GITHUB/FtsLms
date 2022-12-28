<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\Users\StoreUserRequest;
use App\Http\Requests\Permissions\Users\UpdateUserRequest;
use App\Http\Resources\Collections\Permissions\UsersCollection;
use App\Http\Resources\Permissions\UserResource;
use App\Models\User;
use App\Traits\Jsonify;
use Exception;

class UserController extends Controller
{
    use Jsonify;

    public function __construct()
    {
        parent::__permissions('users');
    }

    public function index()
    {
        $data = (new UsersCollection(User::with('roles.permissions')->get()));

        return self::jsonSuccess(message: 'Users retreived successfully.', data: $data, code: 200);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->safe()->except('roles'));

            $user->syncRoles($request->safe()->only('roles'));

            return self::jsonSuccess(message: 'User saved successfully!', data: $user);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(User $user)
    {
        return self::jsonSuccess(message: 'Users retreived successfully.', data: new UserResource($user->load('roles.permissions')));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->safe()->except('roles'));

            if ($request->safe()->has('roles')) {
                $user->syncRoles($request->safe()->only('roles'));
            }

            return self::jsonSuccess(message: 'User updated successfully!', data: new UserResource($user->load('roles.permissions')));
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $user->syncRoles();

        $user->delete();

        return self::jsonSuccess(message: 'User deleted successfully.');
    }
}
