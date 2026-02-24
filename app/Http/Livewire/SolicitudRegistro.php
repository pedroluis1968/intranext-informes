<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SolicitudRegistro extends Component
{
    public $nombre;
    public $apellidos;
    public $dni;
    public $email;
    public $telefono;
    public $comentario;
    public $success = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|min:2',
            'apellidos' => 'required|min:2',
            'dni' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->validateSpanishId($value)) {
                        $fail('El DNI/NIE introducido no es válido.');
                    }
                }
            ],
            'email' => 'required|email|unique:users,email',
            'telefono' => 'required|min:9',
            'comentario' => 'required|min:5',
        ];
    }

    protected $messages = [
        'required' => 'Es obligatorio rellenar este campo.',
        'email' => 'El formato del correo no es válido.',
        'min' => 'El campo debe tener al menos :min caracteres.',
    ];

    private function validateSpanishId($id)
    {
        $id = strtoupper(str_replace([' ', '-'], '', $id));
        if (strlen($id) != 9)
            return false;

        $dniRegEx = '/^[0-9]{8}[A-Z]$/i';
        $nieRegEx = '/^[XYZ][0-9]{7}[A-Z]$/i';

        if (preg_match($dniRegEx, $id)) {
            $number = substr($id, 0, 8);
            $letter = substr($id, -1);
            return substr("TRWAGMYFPDXBNJZSQVHLCKE", $number % 23, 1) == $letter;
        }

        if (preg_match($nieRegEx, $id)) {
            $prefix = ['X' => 0, 'Y' => 1, 'Z' => 2];
            $number = $prefix[substr($id, 0, 1)] . substr($id, 1, 7);
            $letter = substr($id, -1);
            return substr("TRWAGMYFPDXBNJZSQVHLCKE", $number % 23, 1) == $letter;
        }

        return false;
    }

    public function registrar()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $entidadId = DB::table('entidades')->insertGetId([
                'nombre' => trim($this->nombre . ' ' . $this->apellidos),
                'razon_social' => trim($this->nombre . ' ' . $this->apellidos),
                'cif' => $this->dni,
                'mail_ppal' => $this->email,
                'tlf_ppal' => $this->telefono,
                'es_lead' => 1,
                'activa' => 1,
                'actividad_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mod110_expectantes')->insert([
                'entidad_id' => $entidadId,
                'comentario' => $this->comentario,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Determinar tipo de documento
            $tipoDocumento = 'DNI';
            if (preg_match('/^[XYZ]/i', $this->dni)) {
                $tipoDocumento = 'NIE';
            }

            // 1. Registrar en la tabla personas
            $personaId = DB::table('personas')->insertGetId([
                'creador_user_id' => 1,
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'tipo_documento' => $tipoDocumento,
                'numero_documento' => $this->dni,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Registrar teléfono asociado a la persona
            DB::table('telefonos')->insert([
                'persona_id' => $personaId,
                'telefono' => $this->telefono,
                'orden' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Registrar email asociado a la persona
            DB::table('emails')->insert([
                'persona_id' => $personaId,
                'email' => $this->email,
                'orden' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Crear enlace persona-entidad
            DB::table('rel_personas_entidades')->insert([
                'persona_id' => $personaId,
                'entidad_id' => $entidadId,
                'rol' => 'COOPERATIVISTA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5. Crear registro en la tabla users
            DB::table('users')->insert([
                'persona_id' => $personaId,
                'departamento_id' => 99,
                'nombre' => trim($this->nombre . ' ' . $this->apellidos),
                'puesto' => 'COOPERATIVISTA',
                'email' => $this->email,
                'password' => \Illuminate\Support\Facades\Hash::make($this->dni),
                'tarifa_asignada_id' => 1,
                'orden_vis' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();


            // Enviar email de bienvenida (Fuera de la transacción para no bloquear el registro)
            try {
                $nombreCompleto = $this->nombre . ' ' . $this->apellidos;
                \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\WelcomeNewExpectante($nombreCompleto));
            } catch (\Exception $e) {
                // Silenciamos el error de email para que el usuario no vea fallos técnicos, 
                // pero el registro ya está guardado en DB.
                \Illuminate\Support\Facades\Log::error("Error enviando email a {$this->email}: " . $e->getMessage());
            }

            $this->success = true;
            $this->reset(['nombre', 'apellidos', 'dni', 'email', 'telefono', 'comentario']);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Hubo un error al procesar tu solicitud: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.solicitud-registro')->layout('layouts.guest');
    }
}
