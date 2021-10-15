<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'publish']);
        Permission::create(['name' => 'unpublish']);

        // create roles and assign existing permissions

        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('edit');
        $role1->givePermissionTo('delete');
        $role1->givePermissionTo('publish');
        $role1->givePermissionTo('unpublish');

        $role2 = Role::create(['name' => 'user']);


        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("123456789"),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make("123456789"),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin3',
            'email' => 'admin3@gmail.com',
            'password' => Hash::make("123456789"),
        ]);
        $user->assignRole($role1);
        // customer
        $user = \App\Models\User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make("123456789"),
        ]);
        $user->assignRole($role2);

    }
}
