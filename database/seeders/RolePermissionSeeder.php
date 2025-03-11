<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'it',
            'user',
            'supervisor',
            'management'
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@nexgen.com',
        ]);


        // admin user added admin role
        $user = User::all()->first();
        $role = Role::all()->first();
        $user->assignRole($role);

        //permission currently confirmed
        $permissions = [];

        // foreach ($permissions as $permission) {
        //     DB::table('permissions')->insert([
        //         'name' => $permission,
        //         'guard_name' => 'web'
        //     ]);
        // }
    }
}
