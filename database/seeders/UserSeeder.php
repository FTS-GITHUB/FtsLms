<?php

namespace Database\Seeders;

use App\Enums\Permissions\RoleTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::firstOrCreate(['name' => RoleTypeEnum::SUPER_ADMIN]);

        $user = User::create([
            'firstName' => 'Super ',
            'lastName' => 'Admin',
            'phone' => '1234556789',
            'type' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'state' => 'active',
            'password' => Hash::make('password'),
        ])->assignRole($superAdmin);

        $token = $user->createToken('auth')->plainTextToken;

        dump("Super Admin Token : $token");
    }
}
