<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Cupo;
use App\Models\Role;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $prestadorRole = Role::firstOrCreate([
            'name' => 'Prestador',
        ], [
            'description' => 'Crea citas y administra sus cupos',
        ]);

        $solicitanteRole = Role::firstOrCreate([
            'name' => 'Solicitante',
        ], [
            'description' => 'Se suscribe a prestadores y reserva cupos',
        ]);

        $prestadorDemo = User::firstOrCreate([
            'email' => 'prestador.demo@gigantedelhogar.com.co',
        ], [
            'name' => 'Prestador Demo',
            'password' => Hash::make('password'),
        ]);

        $solicitanteDemo = User::firstOrCreate([
            'email' => 'solicitante.demo@gigantedelhogar.com.co',
        ], [
            'name' => 'Solicitante Demo',
            'password' => Hash::make('password'),
        ]);

        $mixtoDemo = User::firstOrCreate([
            'email' => 'mixto.demo@gigantedelhogar.com.co',
        ], [
            'name' => 'Usuario Mixto',
            'password' => Hash::make('password'),
        ]);

        $prestadorDemo->assignRoles([$prestadorRole->id]);
        $solicitanteDemo->assignRoles([$solicitanteRole->id]);
        $mixtoDemo->assignRoles([$prestadorRole->id, $solicitanteRole->id]);

        $citaUno = Cita::firstOrCreate([
            'prestador_id' => $prestadorDemo->id,
            'descripcion' => 'Consulta general',
            'fecha' => Carbon::now()->addDays(3)->toDateString(),
        ], [
            'cupos_totales' => 3,
            'cupos_disponibles' => 3,
        ]);

        $citaDos = Cita::firstOrCreate([
            'prestador_id' => $prestadorDemo->id,
            'descripcion' => 'Revisión técnica',
            'fecha' => Carbon::now()->addDays(5)->toDateString(),
        ], [
            'cupos_totales' => 2,
            'cupos_disponibles' => 2,
        ]);

        $citaTres = Cita::firstOrCreate([
            'prestador_id' => $mixtoDemo->id,
            'descripcion' => 'Atención express',
            'fecha' => Carbon::now()->addDays(4)->toDateString(),
        ], [
            'cupos_totales' => 4,
            'cupos_disponibles' => 4,
        ]);

        Suscripcion::firstOrCreate([
            'solicitante_id' => $solicitanteDemo->id,
            'prestador_id' => $prestadorDemo->id,
        ]);

        Suscripcion::firstOrCreate([
            'solicitante_id' => $mixtoDemo->id,
            'prestador_id' => $prestadorDemo->id,
        ]);

        if (Cupo::firstOrCreate([
            'cita_id' => $citaUno->id,
            'solicitante_id' => $solicitanteDemo->id,
        ])->wasRecentlyCreated) {
            $citaUno->decrement('cupos_disponibles');
        }

        if (Cupo::firstOrCreate([
            'cita_id' => $citaDos->id,
            'solicitante_id' => $mixtoDemo->id,
        ])->wasRecentlyCreated) {
            $citaDos->decrement('cupos_disponibles');
        }

        $citaTres->refresh();
    }
}
