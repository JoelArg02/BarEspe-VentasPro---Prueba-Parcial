<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            'usuarios.index',
            'usuarios.create',
            'categorias.index',
            'categorias.create',
            'productos.index',
            'productos.create',
            'ventas.index',
            'ventas.create',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $secre   = Role::firstOrCreate(['name' => 'secre']);
        $bodega  = Role::firstOrCreate(['name' => 'bodega']);
        $cajera  = Role::firstOrCreate(['name' => 'cajera']);

        $admin->syncPermissions($permisos);

        $secre->syncPermissions([
            'usuarios.index',
            'usuarios.create',
        ]);

        $bodega->syncPermissions([
            'categorias.index',
            'categorias.create',
            'productos.index',
            'productos.create',
        ]);

        $cajera->syncPermissions([
            'ventas.index',
            'ventas.create',
        ]);
    }
}
