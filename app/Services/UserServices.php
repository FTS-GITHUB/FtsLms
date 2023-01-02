<?php

namespace App\Services;

use App\Models\User;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserServices extends BaseServices
{
    use Jsonify;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
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

    public function create()
    {
        DB::beginTransaction();
        try {
            $roles = Role::pluck('name', 'name')->all();
            DB::commit();

            return self::jsonSuccess(message: '', data: $roles);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
            DB::commit();

            return self::jsonSuccess(message: '', data: $user);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            DB::commit();

            return self::jsonSuccess(message: '', data: $user);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    // public function update($id, $request)
    // {
    //     $user = $this->findById($id);
    //     if ($user) {
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->phone = $request->phone;
    //         $user->photo = $request->photo;
    //         $user->save();
    //     }
    //     return $user;
    // }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->findById($id);

            DB::commit();

            return self::jsonSuccess(message: '', data: $user);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
