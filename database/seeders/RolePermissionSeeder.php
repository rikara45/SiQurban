<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $rolePenjual = Role::create(['name' => 'penjual']);
        $rolePembeli = Role::create(['name' => 'pembeli']);

        // create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'browse products']);
        Permission::create(['name' => 'purchase products']);

        // assign permissions to roles
        $roleAdmin->givePermissionTo(Permission::all());

        $rolePenjual->givePermissionTo('manage products');
        $rolePenjual->givePermissionTo('manage orders');

        $rolePembeli->givePermissionTo('browse products');
        $rolePembeli->givePermissionTo('purchase products');

        // Create Admin User
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@siqurban.com',
        ]);
        $admin->assignRole($roleAdmin);

        // Create Penjual User
        $penjual = User::factory()->create([
            'name' => 'Dimas Darmawanto',
            'email' => 'dimas@siqurban.com',
        ]);
        $penjual->assignRole($rolePenjual);

        // Create Pembeli User
        $pembeli = User::factory()->create([
            'name' => 'Ramdhan Raganni',
            'email' => 'agan@siqurban.com',
        ]);
        $pembeli->assignRole($rolePembeli);
    }
}