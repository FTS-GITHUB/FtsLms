<?php

namespace App\Services;

use App\Models\User;
use App\Services\BaseServices;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserServices extends BaseServices
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        $model = $this->model;
        return $this->model->paginate(10);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return $roles;
    }

    public function add($request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return $user;
        // $user->notify(new UserNotification("A new user has visited on your application."));
        // $this->smsService->send($user->phone, 'Your account created successfully');
        return $user;
    }
    public function show($id)
    {
        try {
            $user = User::find($id);
            return $user;
        } catch (\Throwable $th) {
            throw $th;
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
        $user = $this->findById($id);

        if($user) {
            $user->notify(new UserNotification("your record is deleted from our site."));
            $user->delete();
        }
        return $user;
    }
}
