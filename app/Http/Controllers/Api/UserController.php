<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\Users\StoreUserRequest;
use App\Http\Requests\Permissions\Users\UpdateUserRequest;
use App\Http\Resources\Collections\Permissions\UsersCollection;
use App\Http\Resources\Permissions\UserResource;
use App\Models\Image;
use App\Models\User;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Jsonify;

    public function __construct()
    {
        parent::__permissions('users');
    }

    public function index()
    {
        DB::beginTransaction();
        try {
            $data = (new UsersCollection(User::with(['roles.permissions'])->get()));
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->safe()->only('roles'));

            $user = Image::create([
                'url' => cloudinary()->upload($request->file('avatar')->getRealPath())->getSecurePath(),
                'imageable_id' => $user->id,
                'imageable_type' => \App\Models\User::class,

            ]);
            DB::commit();

            return self::jsonSuccess(message: 'User saved successfully!', data: $user);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            $user = self::jsonSuccess(message: 'Users retreived successfully.', data: new UserResource($user->load('roles.permissions')));

            DB::commit();

            return self::jsonSuccess(message: 'User retreived successfully!', data: $user);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
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
