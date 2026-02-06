<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Limpiar la caché de permisos por si acaso
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear los Permisos (acciones que se pueden hacer)
        // Definimos permisos básicos para Productos
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'borrar productos']);
        Permission::create(['name' => 'ver estadisticas']);

        // Crear los Roles y asignarles permisos
        
        // ROL ADMIN
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        // ROL USUARIO
        $roleUser = Role::create(['name' => 'usuario']);
        $roleUser->givePermissionTo([
            'ver productos',
            'crear productos',
            'editar productos',
        ]);

        // Crear usuarios de prueba

        // Usuario Administrador
        $userAdmin = User::factory()->create([
            'name' => 'Admin Boss',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        $userAdmin->assignRole($roleAdmin);

        // Usuario Normal
        $userNormal = User::factory()->create([
            'name' => 'Usuario Normal',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
        ]);
        $userNormal->assignRole($roleUser);
    }
}
