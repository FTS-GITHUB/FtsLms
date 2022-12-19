<?php

namespace Database\Seeders;

use App\Helpers\GlobalHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsByRoutes = GlobalHelper::getPermissionsByRoutes();

        $guards = array_keys(config('auth.guards'));

        foreach ($guards as $key => $guard) {
            foreach ($permissionsByRoutes as $key => $permission) {
                if($guard == 'sanctum')
                {
                    Permission::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => $guard
                    ]);
                }
            }
        }
    }
}
