<?php

namespace Database\Seeders;

use App\Models\Inscripcione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InscripcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Inscripcione::create([
                'nombre_completo' => 'Pedraza',
                'direccion' => 'Los altos',
                'clave_proyecto' => 'ASPT',
                'comite' => 'Comite',
                'alcaldia' => 'Alcaldia',
                'telefono' => 'Telefono',
                'concepto' => 'Concepto',
                'importe' => 1000.00,
                'numero_solicitud' => 'No. solicitud 1',
                'fecha_deposito' => '2025-02-01 00:00:00',
                'fecha_registro' => '2025-02-01 00:00:00',
                'hora_registro' => '23:21:49',
                'observaciones' => 'Primer registro en 2025',
                'estado' => 1
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            Inscripcione::create([
                'nombre_completo' => 'Gonzalo',
                'direccion' => 'Los altos',
                'clave_proyecto' => 'ASPT',
                'comite' => 'Comite',
                'alcaldia' => 'Alcaldia',
                'telefono' => 'Telefono',
                'concepto' => 'Concepto',
                'importe' => 1000.00,
                'numero_solicitud' => 'No. solicitud 1',
                'fecha_deposito' => '2026-01-01 00:00:00',
                'fecha_registro' => '2026-01-01 00:00:00',
                'hora_registro' => '23:21:49',
                'observaciones' => 'Primer registro en 2025',
                'estado' => 1
            ]);
        }
    }
}
