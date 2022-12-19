<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Traits\Jsonify;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use App\Services\Permissions\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Collections\Permissions\UsersCollection;

class UserController extends Controller
{
    use Jsonify;

    public function __construct(private UserService $userService)
    {
        parent::__permissions('users');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = (new UsersCollection(User::with('permissions')->get()));

        return self::jsonSuccess(message: 'Roles retreived successfully.', data: $data, code: 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = $this->userService->create();
            return self::jsonSuccess(UserResource::collection($roles), message: 'User Retrived successfully.');
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
    public function store(UserRequest $request)
    {
        try {
            $users = $this->userService->add($request);
            return self::jsonSuccess(UserResource::collection($users), message: 'User create successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userService->show($id);
            return self::jsonSuccess(data: $user, message: 'User retrieved successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        try {
            $id = $user->id;
            $user = User::find($id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles->pluck('name', 'name')->all();
            $data = [$user, $roles, $userRole];
            return self::jsonSuccess(data: $data, message: 'User retrieved successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $id    = $user->id;
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            return self::jsonSuccess(data: $user, message: 'User retrieved successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $id = $user->id;
            User::find($id)->delete();
            return self::jsonSuccess(message: 'User deleted successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
