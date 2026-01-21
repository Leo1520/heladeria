<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@heladeria.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'telefono' => '987654321',
            'direccion' => 'Av. Principal 123, Santa Rosa',
            'activo' => true,
            'email_verified_at' => now(),
        ]);

        // Cliente de prueba
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('cliente123'),
            'rol' => 'cliente',
            'telefono' => '987123456',
            'direccion' => 'Jr. Los Helados 456, Santa Rosa',
            'activo' => true,
            'email_verified_at' => now(),
        ]);

        // Otro cliente de prueba
        User::create([
            'name' => 'María García',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('maria123'),
            'rol' => 'cliente',
            'telefono' => '912345678',
            'direccion' => 'Av. Dulce 789, Santa Rosa',
            'activo' => true,
            'email_verified_at' => now(),
        ]);
    }
}
