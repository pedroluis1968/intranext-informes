<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$usersToFix = [
    [
        'entidad_id' => 33,
        'nombre' => 'Pedro Luis',
        'apellidos' => 'Santana Martínez',
        'cif' => '52095032D',
        'email' => 'pedroluis@unaweb.es',
        'telefono' => '664532283'
    ],
    [
        'entidad_id' => 34,
        'nombre' => 'Óscar',
        'apellidos' => 'Pascual Zayaas',
        'cif' => '00000000T',
        'email' => 'oscar@creditel.es',
        'telefono' => '911263252'
    ]
];

foreach ($usersToFix as $data) {
    echo "Processing Entidad ID {$data['entidad_id']} ({$data['email']})...\n";

    // Check if user already exists
    if (Illuminate\Support\Facades\DB::table('users')->where('email', $data['email'])->exists()) {
        echo "User already exists in 'users' table. Skipping.\n";
        continue;
    }

    try {
        Illuminate\Support\Facades\DB::beginTransaction();

        $tipoDocumento = preg_match('/^[XYZ]/i', $data['cif']) ? 'NIE' : 'DNI';

        // 1. Persona
        $personaId = Illuminate\Support\Facades\DB::table('personas')->insertGetId([
            'creador_user_id' => 1,
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $data['cif'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created Persona ID: $personaId\n";

        // 2. Teléfono
        Illuminate\Support\Facades\DB::table('telefonos')->insert([
            'persona_id' => $personaId,
            'telefono' => $data['telefono'],
            'orden' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Email
        Illuminate\Support\Facades\DB::table('emails')->insert([
            'persona_id' => $personaId,
            'email' => $data['email'],
            'orden' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Relación
        Illuminate\Support\Facades\DB::table('rel_personas_entidades')->insert([
            'persona_id' => $personaId,
            'entidad_id' => $data['entidad_id'],
            'rol' => 'COOPERATIVISTA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. User
        $userId = Illuminate\Support\Facades\DB::table('users')->insertGetId([
            'persona_id' => $personaId,
            'departamento_id' => 99,
            'nombre' => trim($data['nombre'] . ' ' . $data['apellidos']),
            'puesto' => 'COOPERATIVISTA',
            'email' => $data['email'],
            'password' => Illuminate\Support\Facades\Hash::make($data['cif']),
            'tarifa_asignada_id' => 1,
            'orden_vis' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created User ID: $userId\n";

        Illuminate\Support\Facades\DB::commit();
        echo "Transaction committed successfully.\n\n";

    } catch (\Exception $e) {
        Illuminate\Support\Facades\DB::rollBack();
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "Trace: " . $e->getTraceAsString() . "\n\n";
    }
}
