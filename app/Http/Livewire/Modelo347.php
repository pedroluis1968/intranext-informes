<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class Modelo347 extends Component
{
    public $empresa_id = '';
    public $anio = '';

    public $empresas = [];
    public $anios = [];
    public $resultados = [];

    public function mount()
    {
        // Obtener la lista de empresas, ordenadas alfabéticamente
        // Asumo que el campo de nombre puede llamarse 'raz_social' o 'nombre'.
        // Si no existe uno, probar con el otro en la vista.
        $this->empresas = Empresa::all();

        // Generar lista de años (el actual y los 5 últimos)
        $currentYear = date('Y');
        for ($i = 0; $i <= 5; $i++) {
            $this->anios[] = $currentYear - $i;
        }

        // Por defecto pre-seleccionar el año más reciente (opcional)
        $this->anio = $currentYear;
    }

    public function emitir()
    {
        $this->validate([
            'empresa_id' => 'required',
            'anio' => 'required|numeric'
        ]);

        // Realizamos la consulta para agrupar las facturas por NIF y Razón Social
        // Separando los totales por trimestres (T1, T2, T3, T4)
        // Hacemos LEFT JOIN con 'entidades' para sacar su 'razon_social' o 'nombre'
        // si en la factura está vacío.
        $resultadosRaw = DB::table('d_frav_cab')
            ->leftJoin('entidades', 'd_frav_cab.cliente_id', '=', 'entidades.id')
            ->select(
                'd_frav_cab.nif',
                DB::raw("COALESCE(NULLIF(TRIM(d_frav_cab.raz_social), ''), entidades.razon_social, entidades.nombre, 'Sin Nombre') as raz_social_calculada"),
                DB::raw('SUM(d_frav_cab.baseimp + d_frav_cab.impiva) as total_anual'),
                DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 1 AND 3 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t1'),
                DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 4 AND 6 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t2'),
                DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 7 AND 9 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t3'),
                DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 10 AND 12 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t4')
            )
            ->where('d_frav_cab.empresa_id', $this->empresa_id)
            ->whereYear('d_frav_cab.fecha_emision', $this->anio)
            ->groupBy('d_frav_cab.nif', 'raz_social_calculada')
            ->having('total_anual', '>', 3005.06)
            ->orderBy('raz_social_calculada')
            ->get();

        // Convertimos a array y mapeamos para restaurar la variable y darle formato
        $this->resultados = $resultadosRaw->map(function ($item) {
            $item->raz_social = $item->raz_social_calculada;
            $item->total_anual = round($item->total_anual, 2);
            $item->t1 = round($item->t1, 2);
            $item->t2 = round($item->t2, 2);
            $item->t3 = round($item->t3, 2);
            $item->t4 = round($item->t4, 2);
            return (array) $item;
        })->toArray();
    }

    // Exportación nativa a CSV
    public function exportarCSV()
    {
        if (empty($this->resultados)) {
            return;
        }

        $csvFileName = 'modelo_347_' . $this->anio . '.csv';

        return response()->streamDownload(function () {
            $file = fopen('php://output', 'w');

            // Añadir el BOM de UTF-8 para que Excel detecte acentos y eñes correctamente
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // Escribir cabeceras separadas por punto y coma
            fputcsv($file, ['NIF', 'Razón Social', 'Total Anual', '1T', '2T', '3T', '4T'], ';');

            foreach ($this->resultados as $row) {
                // Escribir las filas transformando puntos por comas y sin separador de miles si es necesario
                // para que Excel lo interprete como importe
                fputcsv($file, [
                    $row['nif'],
                    $row['raz_social'],
                    number_format($row['total_anual'], 2, ',', ''),
                    number_format($row['t1'], 2, ',', ''),
                    number_format($row['t2'], 2, ',', ''),
                    number_format($row['t3'], 2, ',', ''),
                    number_format($row['t4'], 2, ',', '')
                ], ';');
            }

            fclose($file);
        }, $csvFileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        return view('livewire.modelo347')->layout('layouts.tailwind');
    }
}
