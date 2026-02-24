<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;

class Modelo347 extends Component
{
    public $empresa_id = '';
    public $anio = '';

    public $empresas = [];
    public $anios = [];
    public $resultados = [];

    // Propiedades para el modal de email
    public $showEmailModal = false;
    public $emailTo = '';
    public $emailSubject = '';
    public $emailBody = '';
    public $selectedRow = null;

    public function mount()
    {
        // Obtener la lista de empresas, ordenadas alfabéticamente
        $this->empresas = Empresa::all();

        // Generar lista de años (el actual y los 5 últimos)
        $currentYear = date('Y');
        for ($i = 0; $i <= 5; $i++) {
            $this->anios[] = $currentYear - $i;
        }

        $this->anio = $currentYear;
    }

    public function emitir()
    {
        $this->validate([
            'empresa_id' => 'required',
            'anio' => 'required|numeric'
        ]);

        $resultadosRaw = DB::table('d_frav_cab')
            ->leftJoin('entidades', 'd_frav_cab.cliente_id', '=', 'entidades.id')
            ->select(
            'd_frav_cab.nif',
            'entidades.mail_ppal',
            DB::raw("COALESCE(NULLIF(TRIM(d_frav_cab.raz_social), ''), entidades.razon_social, entidades.nombre, 'Sin Nombre') as raz_social_calculada"),
            DB::raw('SUM(d_frav_cab.baseimp + d_frav_cab.impiva) as total_anual'),
            DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 1 AND 3 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t1'),
            DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 4 AND 6 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t2'),
            DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 7 AND 9 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t3'),
            DB::raw('SUM(CASE WHEN MONTH(d_frav_cab.fecha_emision) BETWEEN 10 AND 12 THEN d_frav_cab.baseimp + d_frav_cab.impiva ELSE 0 END) as t4')
        )
            ->where('d_frav_cab.empresa_id', $this->empresa_id)
            ->whereYear('d_frav_cab.fecha_emision', $this->anio)
            ->groupBy('d_frav_cab.nif', 'raz_social_calculada', 'entidades.mail_ppal')
            ->having('total_anual', '>', 3005.06)
            ->orderBy('raz_social_calculada')
            ->get();

        $this->resultados = $resultadosRaw->map(function ($item) {
            $item->raz_social = $item->raz_social_calculada;
            $item->total_anual = round($item->total_anual, 2);
            $item->t1 = round($item->t1, 2);
            $item->t2 = round($item->t2, 2);
            $item->t3 = round($item->t3, 2);
            $item->t4 = round($item->t4, 2);
            return (array)$item;
        })->toArray();
    }

    public function prepareEmail($nif)
    {
        // Usar helper collect de forma segura o importar si es necesario
        $this->selectedRow = \Illuminate\Support\Arr::first($this->resultados, function ($value) use ($nif) {
            return $value['nif'] === $nif;
        });

        if (!$this->selectedRow)
            return;

        $empresaEmisora = Empresa::find($this->empresa_id);
        $nombreEmisora = $empresaEmisora ? ($empresaEmisora->raz_social ?? $empresaEmisora->nombre) : 'Nuestra Empresa';

        $this->emailTo = $this->selectedRow['mail_ppal'] ?? '';
        $this->emailSubject = "INFORME MODELO 347 DE " . $nombreEmisora;

        $body = "Adjunto remitimos el resumen anual del modelo 347 de las facturas emitidas por " . $nombreEmisora;
        $body .= " del año " . $this->anio . " a la entidad " . $this->selectedRow['raz_social'] . " y su cif " . $this->selectedRow['nif'] . ".\n\n";
        $body .= "Datos del informe:\n";
        $body .= "--------------------------\n";
        $body .= "Total Anual: " . number_format($this->selectedRow['total_anual'], 2, ',', '.') . " €\n";
        $body .= "1er Trimestre: " . number_format($this->selectedRow['t1'], 2, ',', '.') . " €\n";
        $body .= "2do Trimestre: " . number_format($this->selectedRow['t2'], 2, ',', '.') . " €\n";
        $body .= "3er Trimestre: " . number_format($this->selectedRow['t3'], 2, ',', '.') . " €\n";
        $body .= "4to Trimestre: " . number_format($this->selectedRow['t4'], 2, ',', '.') . " €";

        $this->emailBody = $body;
        $this->showEmailModal = true;
    }
    public function sendEmailTest()
    {
        Mail::queue(new MailTest());
    }

    public function sendEmail()
    {
        // Forzamos que si el campo está vacío por algún motivo, no rompa la validación silenciosamente
        if (empty($this->emailTo)) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error',
                'text' => 'El campo destinatario es obligatorio.'
            ]);
            return;
        }

        try {
            // Usamos Mail::send con una clausula simple para asegurar el envío
            Mail::raw($this->emailBody, function ($message) {
                $message->from('intranext@intranext.es', 'Intranext')
                    ->to($this->emailTo)
                    ->subject($this->emailSubject);
            });

            // Si llegamos aquí, el envío no ha lanzado excepción
            $this->showEmailModal = false;

            $this->dispatchBrowserEvent('swal:alert', [
                'icon' => 'success',
                'title' => '¡Enviado!',
                'text' => 'El email se ha enviado correctamente a ' . $this->emailTo
            ]);

        }
        catch (\Exception $e) {
            // Si hay un error, lo mostramos claramente
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error de envío',
                'text' => $e->getMessage()
            ]);

            // Log para revisión técnica si fuera necesario
            \Illuminate\Support\Facades\Log::error("Error enviando 347: " . $e->getMessage());
        }
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
