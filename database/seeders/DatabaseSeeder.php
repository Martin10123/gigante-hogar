<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Prestador',
        ], [
            'description' => 'Crea citas y administra sus cupos',
        ]);

        Role::firstOrCreate([
            'name' => 'Solicitante',
        ], [
            'description' => 'Se suscribe a prestadores y reserva cupos',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Prestador Demo',
            'email' => 'prestador@example.com',
        ]);
    }
}
