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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use Jsonify;

    public function __construct()
    {
        parent::__permissions('users', 'logout');
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
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'phone' => $request->phone,
                'type' => $request->type,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->safe()->only('roles'));

            $user = Image::create([
                'url' => $request->file('avatar')->store('avatar'),
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
        try {
            $check = Role::where('name', 'super-admin')->first();

            if ($check->name) {
                return self::jsonError('super admin can not be deleted');
            }
            $data = Image::where('imageable_id', $user->id)->first();
            $user->syncRoles();

            $user->delete();
            $data->delete();

            return self::jsonSuccess(message: 'User deleted successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = request()->user(); //or Auth::user()

            // Revoke current user token
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

            return self::jsonSuccess(message: 'User logged out successfully.', code: 200);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function user_state($id)
    {
        try {
            // Get user
            $user = User::firstWhere('id', $id);
            if ($user->state == 'in-active') {
                $user->update([
                    'state' => 'active', // when state is in-active
                ]);
            } else {
                $user->update([
                    'state' => 'in-active', // when state is active
                ]);
            }

            return self::jsonSuccess(message: 'User state '.$user->state.' change successfully.', code: 200);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
