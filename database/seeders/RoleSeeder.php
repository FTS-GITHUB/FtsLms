<?php

namespace Database\Seeders;

use App\Enums\Permissions\RoleTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = RoleTypeEnum::getValues();

        foreach ($roles as $role) Role::firstOrCreate(['name' => $role]);
    }
}
