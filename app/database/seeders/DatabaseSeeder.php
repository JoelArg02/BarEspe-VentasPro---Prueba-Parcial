<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // Usuario administrador
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Usuario secretaria
        $secre = User::factory()->create([
            'name' => 'Secretaria',
            'email' => 'secre@example.com',
            'password' => bcrypt('password'),
        ]);
        $secre->assignRole('secre');

        // Usuario bodega
        $bodega = User::factory()->create([
            'name' => 'Bodega',
            'email' => 'bodega@example.com',
            'password' => bcrypt('password'),
        ]);
        $bodega->assignRole('bodega');

        // Usuario cajera
        $cajera = User::factory()->create([
            'name' => 'Cajera',
            'email' => 'cajera@example.com',
            'password' => bcrypt('password'),
        ]);
        $cajera->assignRole('cajera');
    }
}
