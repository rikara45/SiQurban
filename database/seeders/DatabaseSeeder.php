<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Anda bisa menambahkan factory lain di sini untuk data dummy
        // \App\Models\Category::factory(5)->create();
    }
}