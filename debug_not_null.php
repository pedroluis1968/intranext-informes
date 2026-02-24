<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = ['personas', 'telefonos', 'emails', 'rel_personas_entidades', 'users'];

foreach ($tables as $table) {
    echo "--- TABLE: $table ---\n";
    try {
        $cols = Illuminate\Support\Facades\DB::select("DESCRIBE $table");
        $i = 0;
        foreach ($cols as $col) {
            echo "FIELD: {$col->Field} | TYPE: {$col->Type} | NULL: {$col->Null} | DEFAULT: " . var_export($col->Default, true) . "\n";
            $i++;
            if ($i > 10)
                break;
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "--- END: $table ---\n";
}

