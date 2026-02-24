<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\WithPagination;

class Desktop extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $activePage = 'escritorio';
    public $showFinished = false;
    public $coopViewMode = 'grid'; // 'grid' | 'list'

    // Propiedades del Formulario Cooperativas
    public $showModal = false;
    public $selectedCoopId = null; // ID para edición
    public $coopNombre, $coopRazonSocial, $coopCIF, $coopPoblacion, $coopProvincia, $coopPais, $coopRegistro;
    public $coopSociosMax = 0, $coopSociosReg = 0, $coopSociosEspera = 0, $coopSociosEsperaMax = 0, $coopSociosExpectantes = 0, $coopComentario;
    public $coopEstadoId, $coopTipoInmuebleId, $coopTipoProteccionId;

    // Propiedades del Formulario Expectantes
    public $showExpModal = false;
    public $selectedExpId = null;
    public $expNombre, $expApellidos, $expDNI, $expEmail, $expTelefono, $expComentario;
    public $showDeleteModal = false;
    public $expIdToDelete = null;

    // Propiedades para Borrado de Cooperativas
    public $showDeleteCoopModal = false;
    public $coopIdToDelete = null;

    public $searchCoop = '';
    public $search = '';

    // Propiedades de Socios de Cooperativa
    public $showMembersModal = false;
    public $selectedCoopIdForMembers = null;
    public $selectedCoopNameForMembers = '';
    public $searchMember = '';
    public $sortMemberField = 'entidades.nombre';
    public $sortMemberDirection = 'asc';

    // Propiedades para Vincular/Desvincular
    public $showUnlinkModal = false;
    public $socioIdToUnlink = null;
    public $showLinkModal = false;
    public $searchLinkSocio = '';

    // Propiedades para Inscripción de Expectante a Solicitante
    public $showInscribirModal = false;
    public $socioIdToInscribir = null;
    public $socioNombreToInscribir = '';

    // Propiedades para Socios Registrados
    public $showRegModal = false;
    public $selectedRegId = null;
    public $regNombre, $regApellidos, $regDNI, $regEmail, $regTelefono, $regComentario;
    public $showDeleteRegModal = false;
    public $regIdToDelete = null;
    public $searchReg = '';
    public $sortRegField = 'entidades.nombre';
    public $sortRegDirection = 'asc';

    // Propiedades para ver cooperativas de un socio registrado
    public $showSocioCoopsModal = false;
    public $selectedSocioIdForCoops = null;
    public $selectedSocioNameForCoops = '';

    // Propiedades para gestión de archivos de socios
    public $showUploadFileModal = false;
    public $selectedEntidadIdForFile = null;
    public $selectedEntidadNameForFile = '';
    public $uploadedFile;
    public $fileNombre = '';
    public $fileDescripcion = '';
    public $fileTipoArchivoId = null;

    // Propiedades del Formulario Inmuebles
    public $showInmuebleModal = false;
    public $selectedInmuebleId = null;
    public $inmuebleNombre, $inmueblePromocionId, $inmuebleTipoInmuebleId, $inmuebleTipoProteccionId, $inmuebleEstadoId, $inmuebleComentario;
    public $searchInmueble = '';
    public $sortInmuebleField = 'mod110_inmuebles.nombre';
    public $sortInmuebleDirection = 'asc';
    public $showDeleteInmuebleModal = false;
    public $inmuebleIdToDelete = null;
    public $inmuebleViewMode = 'list'; // 'grid' | 'list'
    public $filterInmuebleTipo = '';
    public $filterInmuebleEstado = '';
    public $filterInmuebleCoop = '';
    public $filterInmueblePromo = '';

    // Propiedades del Formulario Promociones
    public $showPromocionModal = false;
    public $selectedPromocionId = null;
    public $promoNombre, $promoCoopId, $promoComentario;
    public $searchPromocion = '';
    public $sortPromocionField = 'mod110_coop_promociones.nombre_promocion';
    public $sortPromocionDirection = 'asc';
    public $showDeletePromocionModal = false;
    public $promocionIdToDelete = null;

    // Propiedades de Ordenación
    public $sortField = 'entidades.nombre';
    public $sortDirection = 'asc';

    // Propiedades del Perfil
    public $perfilNombre;
    public $perfilPassword;
    public $perfilPasswordConfirmation;
    public $perfilAvatar;

    // Propiedades de Correo Webmail
    public $perfilMailEnabled = false;
    public $perfilMailAddress = '';
    public $perfilMailPop3Host = '';
    public $perfilMailPop3Port = 110;
    public $perfilMailPop3User = '';
    public $perfilMailPop3Pass = '';
    public $perfilMailPop3Encryption = '';
    public $perfilMailSmtpHost = '';
    public $perfilMailSmtpPort = 587;
    public $perfilMailSmtpUser = '';
    public $perfilMailSmtpPass = '';
    public $perfilMailSmtpEncryption = 'tls';

    // Propiedades de Usuarios
    public $selectedUserId = null;
    public $searchUser = '';
    public $activeUserFilter = 'all';
    public $userViewMode = 'grid'; // 'grid' | 'list'
    public $showDeleteUserModal = false;
    public $userIdToDelete = null;
    public $userPerPage = 10;

    // Edición de Usuario
    public $showUserModal = false;
    public $selectedUserEditId = null;
    public $userNick, $userNombre, $userApellidos, $userDNI, $userEmail, $userPuesto, $userDepartamentoId;
    public $userDomicilio, $userCPostal, $userProvinciaId, $userPoblacionId;
    public $userTelefonos = [];
    public $userEmailsList = [];
    public $draftEmail = null;

    public function updatedUserProvinciaId()
    {
        $this->userPoblacionId = null;
    }


    protected $listeners = ['switchPage' => 'setPage'];

    public function mount()
    {
        // Add avatar column to DB if not exists
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'avatar')) {
            \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                $table->string('avatar')->nullable();
            });
        }
    }

    public function setPage($page)
    {
        $this->activePage = $page;
        if ($page === 'perfil') {
            $user = Auth::user();
            $this->perfilNombre = $user->nombre;
            $this->perfilPassword = '';
            $this->perfilPasswordConfirmation = '';
            $this->perfilAvatar = null;

            // Cargar configuración de Webmail
            $mailSettings = DB::table('user_mail_settings')->where('user_id', $user->id)->first();
            if ($mailSettings) {
                $this->perfilMailEnabled = $mailSettings->is_enabled;
                $this->perfilMailAddress = $mailSettings->email_address;
                $this->perfilMailPop3Host = $mailSettings->pop3_host;
                $this->perfilMailPop3Port = $mailSettings->pop3_port;
                $this->perfilMailPop3User = $mailSettings->pop3_username;
                try {
                    $this->perfilMailPop3Pass = $mailSettings->pop3_password ? \Illuminate\Support\Facades\Crypt::decryptString($mailSettings->pop3_password) : '';
                } catch (\Exception $e) {
                    $this->perfilMailPop3Pass = '';
                }
                $this->perfilMailPop3Encryption = $mailSettings->pop3_encryption;

                $this->perfilMailSmtpHost = $mailSettings->smtp_host;
                $this->perfilMailSmtpPort = $mailSettings->smtp_port;
                $this->perfilMailSmtpUser = $mailSettings->smtp_username;
                try {
                    $this->perfilMailSmtpPass = $mailSettings->smtp_password ? \Illuminate\Support\Facades\Crypt::decryptString($mailSettings->smtp_password) : '';
                } catch (\Exception $e) {
                    $this->perfilMailSmtpPass = '';
                }
                $this->perfilMailSmtpEncryption = $mailSettings->smtp_encryption;
            } else {
                $this->perfilMailEnabled = false;
                $this->perfilMailAddress = $user->email ?? '';
                $this->perfilMailPop3Host = '';
                $this->perfilMailPop3Port = 110;
                $this->perfilMailPop3User = '';
                $this->perfilMailPop3Pass = '';
                $this->perfilMailPop3Encryption = '';
                $this->perfilMailSmtpHost = '';
                $this->perfilMailSmtpPort = 587;
                $this->perfilMailSmtpUser = '';
                $this->perfilMailSmtpPass = '';
                $this->perfilMailSmtpEncryption = 'tls';
            }
        }
    }

    public function updatePerfil()
    {
        $user = Auth::user();

        $rules = [
            'perfilNombre' => 'required|min:3',
        ];

        if ($this->perfilPassword) {
            $rules['perfilPassword'] = 'min:6|same:perfilPasswordConfirmation';
        }

        if ($this->perfilAvatar) {
            $rules['perfilAvatar'] = 'image|max:3072'; // 3MB Max
        }

        if ($this->perfilMailEnabled) {
            $rules['perfilMailAddress'] = 'required|email';
        }

        $this->validate($rules);

        $data = ['nombre' => $this->perfilNombre];

        if ($this->perfilPassword) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($this->perfilPassword);
        }

        if ($this->perfilAvatar) {
            $path = $this->perfilAvatar->store('avatares', 'public');
            $data['avatar'] = $path;
        }

        DB::table('users')->where('id', $user->id)->update($data);

        // Guardar configuración de Webmail
        $mailData = [
            'is_enabled' => $this->perfilMailEnabled,
            'email_address' => $this->perfilMailAddress,
            'pop3_host' => $this->perfilMailPop3Host ?: null,
            'pop3_port' => $this->perfilMailPop3Port ?: 110,
            'pop3_username' => $this->perfilMailPop3User ?: null,
            'pop3_password' => $this->perfilMailPop3Pass ? \Illuminate\Support\Facades\Crypt::encryptString($this->perfilMailPop3Pass) : null,
            'pop3_encryption' => $this->perfilMailPop3Encryption ?: null,
            'smtp_host' => $this->perfilMailSmtpHost ?: null,
            'smtp_port' => $this->perfilMailSmtpPort ?: 587,
            'smtp_username' => $this->perfilMailSmtpUser ?: null,
            'smtp_password' => $this->perfilMailSmtpPass ? \Illuminate\Support\Facades\Crypt::encryptString($this->perfilMailSmtpPass) : null,
            'smtp_encryption' => $this->perfilMailSmtpEncryption ?: null,
            'updated_at' => now()
        ];

        $existsMail = DB::table('user_mail_settings')->where('user_id', $user->id)->exists();
        if ($existsMail) {
            DB::table('user_mail_settings')->where('user_id', $user->id)->update($mailData);
        } else {
            $mailData['user_id'] = $user->id;
            $mailData['created_at'] = now();
            DB::table('user_mail_settings')->insert($mailData);
        }

        // NO LIMPIAR LOS DATOS DE CORREO, ya que los está visualizando

        $this->perfilPassword = '';
        $this->perfilPasswordConfirmation = '';
        $this->perfilAvatar = null;

        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => '¡Perfil Actualizado!',
            'text' => 'Tus datos se han guardado correctamente.'
        ]);

        // Emit an event to refresh layout avatar
        $this->emit('profileUpdated');
    }

    public function openModal()
    {
        $this->resetForm();
        $this->selectedCoopId = null;
        $this->showModal = true;
    }

    public function editCooperativa($id)
    {
        $this->resetForm();
        $this->selectedCoopId = $id;

        $coop = DB::table('mod110_cooperativas')
            ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
            ->select('mod110_cooperativas.*', 'entidades.*', 'mod110_cooperativas.id as coop_id')
            ->where('mod110_cooperativas.id', $id)
            ->first();

        if ($coop) {
            $this->coopNombre = $coop->nombre;
            $this->coopRazonSocial = $coop->razon_social;
            $this->coopCIF = $coop->cif;
            $this->coopPoblacion = $coop->poblacion;
            $this->coopProvincia = $coop->provincia;
            $this->coopPais = $coop->pais;
            $this->coopRegistro = $coop->registro_cooperativas;
            $this->coopSociosMax = $coop->num_socios_max;
            $this->coopSociosReg = $coop->num_socios_registrados;
            $this->coopSociosEspera = $coop->num_socios_espera;
            $this->coopSociosEsperaMax = $coop->num_socios_espera_max;
            $this->coopSociosExpectantes = $coop->num_socios_expectantes;
            $this->coopComentario = $coop->comentario;
            $this->coopEstadoId = $coop->estado_id;
            $this->coopTipoInmuebleId = $coop->tipo_inmueble_id;
            $this->coopTipoProteccionId = $coop->tipo_proteccion_id;

            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetForm()
    {
        $this->coopNombre = '';
        $this->coopRazonSocial = '';
        $this->coopCIF = '';
        $this->coopPoblacion = '';
        $this->coopProvincia = '';
        $this->coopPais = 'España';
        $this->coopRegistro = '';
        $this->coopSociosMax = 0;
        $this->coopSociosReg = 0;
        $this->coopSociosEspera = 0;
        $this->coopSociosEsperaMax = 0;
        $this->coopSociosExpectantes = 0;
        $this->coopComentario = '';
        $this->coopEstadoId = null;
        $this->coopTipoInmuebleId = null;
        $this->coopTipoProteccionId = null;
        $this->resetErrorBag();
    }

    public function saveCooperativa()
    {
        $this->validate([
            'coopNombre' => 'required|min:3',
            'coopCIF' => 'required',
            'coopSociosMax' => 'required|numeric|min:1',
            'coopSociosReg' => 'nullable|numeric|min:0',
            'coopSociosEspera' => 'nullable|numeric|min:0',
            'coopSociosEsperaMax' => 'nullable|numeric|min:0',
            'coopSociosExpectantes' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            if ($this->selectedCoopId) {
                // MODO EDICIÓN
                $coop = DB::table('mod110_cooperativas')->where('id', $this->selectedCoopId)->first();

                // 1. Actualizar Entidad
                DB::table('entidades')->where('id', $coop->entidad_id)->update([
                    'nombre' => $this->coopNombre,
                    'razon_social' => $this->coopRazonSocial ?: $this->coopNombre,
                    'cif' => $this->coopCIF,
                    'poblacion' => $this->coopPoblacion,
                    'provincia' => $this->coopProvincia,
                    'pais' => $this->coopPais ?: 'España',
                    'updated_at' => now(),
                ]);

                // 2. Actualizar Cooperativa
                DB::table('mod110_cooperativas')->where('id', $this->selectedCoopId)->update([
                    'registro_cooperativas' => $this->coopRegistro,
                    'num_socios_registrados' => $this->coopSociosReg ?: 0,
                    'num_socios_max' => $this->coopSociosMax ?: 0,
                    'num_socios_espera' => $this->coopSociosEspera ?: 0,
                    'num_socios_espera_max' => $this->coopSociosEsperaMax ?: 0,
                    'num_socios_expectantes' => $this->coopSociosExpectantes ?: 0,
                    'comentario' => $this->coopComentario,
                    'estado_id' => $this->coopEstadoId,
                    'tipo_inmueble_id' => $this->coopTipoInmuebleId,
                    'tipo_proteccion_id' => $this->coopTipoProteccionId,
                    'updated_at' => now(),
                ]);

                $msg = 'Modificaciones registradas correctamente.';
            } else {
                // MODO ALTA
                // 1. Crear Entidad
                $entidadId = DB::table('entidades')->insertGetId([
                    'nombre' => $this->coopNombre,
                    'razon_social' => $this->coopRazonSocial ?: $this->coopNombre,
                    'cif' => $this->coopCIF,
                    'poblacion' => $this->coopPoblacion,
                    'provincia' => $this->coopProvincia,
                    'pais' => $this->coopPais ?: 'España',
                    'activa' => 1,
                    'actividad_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 2. Crear Cooperativa
                DB::table('mod110_cooperativas')->insert([
                    'empresa_id' => 1,
                    'entidad_id' => $entidadId,
                    'registro_cooperativas' => $this->coopRegistro,
                    'num_socios_registrados' => $this->coopSociosReg ?: 0,
                    'num_socios_max' => $this->coopSociosMax ?: 0,
                    'num_socios_espera' => $this->coopSociosEspera ?: 0,
                    'num_socios_espera_max' => $this->coopSociosEsperaMax ?: 0,
                    'num_socios_expectantes' => $this->coopSociosExpectantes ?: 0,
                    'comentario' => $this->coopComentario,
                    'estado_id' => $this->coopEstadoId,
                    'tipo_inmueble_id' => $this->coopTipoInmuebleId,
                    'tipo_proteccion_id' => $this->coopTipoProteccionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $msg = 'Cooperativa dada de alta correctamente.';
            }

            DB::commit();
            $this->showModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function confirmDeleteCooperativa($id)
    {
        $this->coopIdToDelete = $id;
        $this->showDeleteCoopModal = true;
    }

    public function deleteCooperativa()
    {
        if ($this->coopIdToDelete) {
            try {
                DB::beginTransaction();

                $coop = DB::table('mod110_cooperativas')->where('id', $this->coopIdToDelete)->first();
                if ($coop) {
                    $entidadId = $coop->entidad_id;

                    // Borrar registro cooperativa
                    DB::table('mod110_cooperativas')->where('id', $this->coopIdToDelete)->delete();

                    // Opcionalmente borrar la entidad asociada
                    DB::table('entidades')->where('id', $entidadId)->delete();
                }

                DB::commit();

                $this->showDeleteCoopModal = false;
                $this->coopIdToDelete = null;

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Eliminada!',
                    'text' => 'La cooperativa ha sido eliminada correctamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la cooperativa: ' . $e->getMessage()
                ]);
            }
        }
    }


    // --- LÓGICA DE EXPECTANTES ---

    public function openExpModal()
    {
        $this->resetExpForm();
        $this->selectedExpId = null;
        $this->showExpModal = true;
    }

    public function closeExpModal()
    {
        $this->showExpModal = false;
    }

    private function resetExpForm()
    {
        $this->expNombre = '';
        $this->expApellidos = '';
        $this->expDNI = '';
        $this->expEmail = '';
        $this->expTelefono = '';
        $this->expComentario = '';
        $this->resetErrorBag();
    }

    public function editExpectante($id)
    {
        $this->resetExpForm();
        $this->selectedExpId = $id;

        $exp = DB::table('mod110_expectantes')
            ->join('entidades', 'mod110_expectantes.entidad_id', '=', 'entidades.id')
            ->select(
                'mod110_expectantes.comentario as exp_comentario',
                'entidades.nombre',
                'entidades.cif',
                'entidades.mail_ppal',
                'entidades.tlf_ppal',
                'mod110_expectantes.id as exp_id'
            )
            ->where('mod110_expectantes.id', $id)
            ->first();

        if ($exp) {
            $this->expNombre = $exp->nombre;
            $this->expApellidos = '';
            $this->expDNI = $exp->cif ?? '';
            $this->expEmail = $exp->mail_ppal ?? '';
            $this->expTelefono = $exp->tlf_ppal ?? '';
            $this->expComentario = $exp->exp_comentario;

            $this->showExpModal = true;
        }
    }

    public function saveExpectante()
    {
        $this->validate([
            'expNombre' => 'required|min:2',
            'expDNI' => 'required',
            'expEmail' => 'required|email',
            'expTelefono' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($this->selectedExpId) {
                // ACTUALIZAR
                $expRecord = DB::table('mod110_expectantes')->where('id', $this->selectedExpId)->first();

                DB::table('entidades')->where('id', $expRecord->entidad_id)->update([
                    'nombre' => trim($this->expNombre . ' ' . $this->expApellidos),
                    'razon_social' => trim($this->expNombre . ' ' . $this->expApellidos),
                    'cif' => $this->expDNI,
                    'mail_ppal' => $this->expEmail,
                    'tlf_ppal' => $this->expTelefono,
                    'updated_at' => now(),
                ]);

                DB::table('mod110_expectantes')->where('id', $this->selectedExpId)->update([
                    'comentario' => $this->expComentario,
                    'updated_at' => now(),
                ]);

                $msg = 'Socio expectante actualizado correctamente.';
            } else {
                // DAR DE ALTA
                $entidadId = DB::table('entidades')->insertGetId([
                    'nombre' => trim($this->expNombre . ' ' . $this->expApellidos),
                    'razon_social' => trim($this->expNombre . ' ' . $this->expApellidos),
                    'cif' => $this->expDNI,
                    'mail_ppal' => $this->expEmail,
                    'tlf_ppal' => $this->expTelefono,
                    'es_lead' => 1,
                    'activa' => 1,
                    'actividad_id' => 1, // Por defecto
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('mod110_expectantes')->insert([
                    'entidad_id' => $entidadId,
                    'comentario' => $this->expComentario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $msg = 'Socio expectante registrado correctamente.';
            }

            DB::commit();
            $this->showExpModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar expectante: ' . $e->getMessage());
        }
    }

    public function confirmDeleteExpectante($id)
    {
        $this->expIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteExpectante()
    {
        if ($this->expIdToDelete) {
            try {
                DB::beginTransaction();

                $exp = DB::table('mod110_expectantes')->where('id', $this->expIdToDelete)->first();
                if ($exp) {
                    $entidadId = $exp->entidad_id;

                    // Borrar registro expectante
                    DB::table('mod110_expectantes')->where('id', $this->expIdToDelete)->delete();

                    // Opcionalmente borrar la entidad (si solo existe para este registro)
                    DB::table('entidades')->where('id', $entidadId)->delete();
                }

                DB::commit();

                $this->showDeleteModal = false;
                $this->expIdToDelete = null;

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Eliminado!',
                    'text' => 'El socio expectante ha sido eliminado correctamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el registro: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // --- MIEMBROS DE COOPERATIVA ---
    public function openMembersModal($coopId)
    {
        $coop = DB::table('mod110_cooperativas')
            ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
            ->where('mod110_cooperativas.id', $coopId)
            ->select('entidades.nombre')
            ->first();

        $this->selectedCoopIdForMembers = $coopId;
        $this->selectedCoopNameForMembers = $coop ? $coop->nombre : '';
        $this->searchMember = '';
        $this->showMembersModal = true;
    }

    public function closeMembersModal()
    {
        $this->showMembersModal = false;
        $this->selectedCoopIdForMembers = null;
    }

    public function sortMembersBy($field)
    {
        if ($this->sortMemberField === $field) {
            $this->sortMemberDirection = $this->sortMemberDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortMemberField = $field;
            $this->sortMemberDirection = 'asc';
        }
    }

    public function confirmUnlinkMember($socioId)
    {
        $this->socioIdToUnlink = $socioId;
        $this->showUnlinkModal = true;
    }

    public function unlinkMember()
    {
        if ($this->socioIdToUnlink) {
            try {
                DB::beginTransaction();
                DB::table('mod110_coop_socios')->where('id', $this->socioIdToUnlink)->delete();

                // Decrementar num_socios_expectantes
                DB::table('mod110_cooperativas')
                    ->where('id', $this->selectedCoopIdForMembers)
                    ->decrement('num_socios_expectantes');

                DB::commit();
                $this->showUnlinkModal = false;
                $this->socioIdToUnlink = null;
                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => 'Desvinculado',
                    'text' => 'El socio ha sido desvinculado de la cooperativa.'
                ]);
            } catch (\Exception $e) {
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo desvincular al socio: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function openLinkSocioModal()
    {
        $this->searchLinkSocio = '';
        $this->showLinkModal = true;
    }

    public function linkSocio($entidadId)
    {
        try {
            // Verificar si ya está vinculado (opcional, pero buena práctica)
            $exists = DB::table('mod110_coop_socios')
                ->where('cooperativa_id', $this->selectedCoopIdForMembers)
                ->where('entidad_id', $entidadId)
                ->exists();

            if ($exists) {
                $this->emit('swal:alert', ['type' => 'warning', 'title' => 'Aviso', 'text' => 'Este socio ya está vinculado a la cooperativa.']);
                return;
            }

            DB::beginTransaction();
            DB::table('mod110_coop_socios')->insert([
                'cooperativa_id' => $this->selectedCoopIdForMembers,
                'entidad_id' => $entidadId,
                'tipo_socio_id' => 1, // 1 = Socio Expectante
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Incrementar num_socios_expectantes
            DB::table('mod110_cooperativas')
                ->where('id', $this->selectedCoopIdForMembers)
                ->increment('num_socios_expectantes');

            DB::commit();

            $this->showLinkModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Vinculado!',
                'text' => 'Socio vinculado correctamente a la cooperativa.'
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo vincular al socio: ' . $e->getMessage()
            ]);
        }
    }

    // --- INSCRIPCIÓN DE EXPECTANTE A SOLICITANTE ---
    public function confirmInscribir($socioTableId, $nombreSocio)
    {
        $this->socioIdToInscribir = $socioTableId;
        $this->socioNombreToInscribir = $nombreSocio;
        $this->showInscribirModal = true;
    }

    public function inscribirSocio()
    {
        if ($this->socioIdToInscribir) {
            try {
                DB::beginTransaction();

                // Actualizar tipo_socio_id de 1 (Expectante) a 2 (Solicitante)
                DB::table('mod110_coop_socios')
                    ->where('id', $this->socioIdToInscribir)
                    ->update([
                        'tipo_socio_id' => 2, // 2 = Socio Solicitante
                        'updated_at' => now(),
                    ]);

                // Ajustar contadores: decrementar expectantes, incrementar registrados
                DB::table('mod110_cooperativas')
                    ->where('id', $this->selectedCoopIdForMembers)
                    ->decrement('num_socios_expectantes');

                DB::table('mod110_cooperativas')
                    ->where('id', $this->selectedCoopIdForMembers)
                    ->increment('num_socios_registrados');

                DB::commit();

                $this->showInscribirModal = false;
                $this->socioIdToInscribir = null;
                $this->socioNombreToInscribir = '';

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Inscrito!',
                    'text' => 'El socio ha sido convertido a Solicitante correctamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo inscribir al socio: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function abrirFormularioContrato()
    {
        // Método placeholder para futura implementación del formulario de contrato
        $this->emit('swal:alert', [
            'type' => 'info',
            'title' => 'Próximamente',
            'text' => 'El formulario de solicitud de ingreso estará disponible en breve.'
        ]);
    }

    // --- LÓGICA DE SOCIOS REGISTRADOS ---

    public function openRegModal()
    {
        $this->resetRegForm();
        $this->selectedRegId = null;
        $this->showRegModal = true;
    }

    public function closeRegModal()
    {
        $this->showRegModal = false;
    }

    private function resetRegForm()
    {
        $this->regNombre = '';
        $this->regApellidos = '';
        $this->regDNI = '';
        $this->regEmail = '';
        $this->regTelefono = '';
        $this->regComentario = '';
        $this->resetErrorBag();
    }

    public function editRegistrado($entidadId)
    {
        $this->resetRegForm();
        $this->selectedRegId = $entidadId;

        $socio = DB::table('entidades')
            ->where('id', $entidadId)
            ->first();

        if ($socio) {
            $this->regNombre = $socio->nombre;
            $this->regApellidos = '';
            $this->regDNI = $socio->cif ?? '';
            $this->regEmail = $socio->mail_ppal ?? '';
            $this->regTelefono = $socio->tlf_ppal ?? '';
            $this->regComentario = $socio->comentario ?? '';

            $this->showRegModal = true;
        }
    }

    public function saveRegistrado()
    {
        $this->validate([
            'regNombre' => 'required|min:2',
            'regDNI' => 'required',
            'regEmail' => 'required|email',
            'regTelefono' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($this->selectedRegId) {
                // ACTUALIZAR
                DB::table('entidades')->where('id', $this->selectedRegId)->update([
                    'nombre' => trim($this->regNombre . ' ' . $this->regApellidos),
                    'razon_social' => trim($this->regNombre . ' ' . $this->regApellidos),
                    'cif' => $this->regDNI,
                    'mail_ppal' => $this->regEmail,
                    'tlf_ppal' => $this->regTelefono,
                    'comentario' => $this->regComentario,
                    'updated_at' => now(),
                ]);

                $msg = 'Socio registrado actualizado correctamente.';
            } else {
                // DAR DE ALTA (crear nuevo socio registrado sin cooperativa asignada)
                $entidadId = DB::table('entidades')->insertGetId([
                    'nombre' => trim($this->regNombre . ' ' . $this->regApellidos),
                    'razon_social' => trim($this->regNombre . ' ' . $this->regApellidos),
                    'cif' => $this->regDNI,
                    'mail_ppal' => $this->regEmail,
                    'tlf_ppal' => $this->regTelefono,
                    'comentario' => $this->regComentario,
                    'es_lead' => 0,
                    'activa' => 1,
                    'actividad_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $msg = 'Socio registrado creado correctamente. Puede vincularlo a cooperativas desde la gestión de cada cooperativa.';
            }

            DB::commit();
            $this->showRegModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar socio registrado: ' . $e->getMessage());
        }
    }

    public function confirmDeleteRegistrado($entidadId)
    {
        $this->regIdToDelete = $entidadId;
        $this->showDeleteRegModal = true;
    }

    public function deleteRegistrado()
    {
        if ($this->regIdToDelete) {
            try {
                DB::beginTransaction();

                // Verificar si tiene cooperativas asociadas
                $coopsCount = DB::table('mod110_coop_socios')
                    ->where('entidad_id', $this->regIdToDelete)
                    ->count();

                if ($coopsCount > 0) {
                    $this->emit('swal:alert', [
                        'type' => 'warning',
                        'title' => 'No se puede eliminar',
                        'text' => 'Este socio está vinculado a ' . $coopsCount . ' cooperativa(s). Desvincúlelo primero.'
                    ]);
                    $this->showDeleteRegModal = false;
                    return;
                }

                // Borrar entidad
                DB::table('entidades')->where('id', $this->regIdToDelete)->delete();

                DB::commit();

                $this->showDeleteRegModal = false;
                $this->regIdToDelete = null;

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Eliminado!',
                    'text' => 'El socio registrado ha sido eliminado correctamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el registro: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function sortRegBy($field)
    {
        if ($this->sortRegField === $field) {
            $this->sortRegDirection = $this->sortRegDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortRegField = $field;
            $this->sortRegDirection = 'asc';
        }
    }

    public function openSocioCoopsModal($entidadId, $nombreSocio)
    {
        $this->selectedSocioIdForCoops = $entidadId;
        $this->selectedSocioNameForCoops = $nombreSocio;
        $this->showSocioCoopsModal = true;
    }

    public function closeSocioCoopsModal()
    {
        $this->showSocioCoopsModal = false;
        $this->selectedSocioIdForCoops = null;
    }

    // --- GESTIÓN DE ARCHIVOS DE SOCIOS ---

    public function openUploadFileModal($entidadId, $nombreEntidad)
    {
        $this->resetFileForm();
        $this->selectedEntidadIdForFile = $entidadId;
        $this->selectedEntidadNameForFile = $nombreEntidad;
        $this->showUploadFileModal = true;
    }

    public function closeUploadFileModal()
    {
        $this->showUploadFileModal = false;
        $this->resetFileForm();
    }

    private function resetFileForm()
    {
        $this->uploadedFile = null;
        $this->fileNombre = '';
        $this->fileDescripcion = '';
        $this->fileTipoArchivoId = null;
        $this->resetErrorBag();
    }

    public function saveFile()
    {
        $this->validate([
            'uploadedFile' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240', // Max 10MB
            'fileNombre' => 'required|min:3',
            'fileTipoArchivoId' => 'required',
        ], [
            'uploadedFile.required' => 'Debe seleccionar un archivo.',
            'uploadedFile.mimes' => 'El archivo debe ser PDF, JPG, PNG, DOC, DOCX, XLS o XLSX.',
            'uploadedFile.max' => 'El archivo no debe superar los 10MB.',
            'fileNombre.required' => 'El nombre del archivo es obligatorio.',
            'fileNombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'fileTipoArchivoId.required' => 'Debe seleccionar un tipo de archivo.',
        ]);

        try {
            DB::beginTransaction();

            // Obtener información del archivo
            $originalName = $this->uploadedFile->getClientOriginalName();
            $extension = $this->uploadedFile->getClientOriginalExtension();
            $mimeType = $this->uploadedFile->getMimeType();
            $size = $this->uploadedFile->getSize();

            // Generar nombre único para el archivo
            $fileName = time() . '_' . uniqid() . '.' . $extension;

            // Guardar el archivo en storage/app/public/documentos
            $path = $this->uploadedFile->storeAs('documentos', $fileName, 'public');

            // 1. Insertar en archivo_documental
            $archivoDocumentalId = DB::table('archivo_documental')->insertGetId([
                'nombre' => $this->fileNombre,
                'descripcion' => $this->fileDescripcion,
                'nombre_archivo' => $fileName,
                'ruta_archivo' => $path,
                'extension' => $extension,
                'mime_type' => $mimeType,
                'tamano' => $size,
                'tipo_archivo_id' => $this->fileTipoArchivoId,
                'entidad_id' => $this->selectedEntidadIdForFile,
                'autor_user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Insertar en archivos_ente (relación)
            DB::table('archivos_ente')->insert([
                'archivo_id' => $archivoDocumentalId,
                'ente_id' => $this->selectedEntidadIdForFile,
                'tipo_ente_id' => 3, // 3 = ENTIDAD según m_tipos_ente
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            $this->showUploadFileModal = false;
            $this->resetFileForm();

            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Archivo Subido!',
                'text' => 'El archivo ha sido vinculado correctamente al socio.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Si hubo error, eliminar el archivo del storage si se guardó
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $this->emit('swal:alert', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo guardar el archivo: ' . $e->getMessage()
            ]);
        }
    }


    // --- GESTIÓN DE INMUEBLES ---

    public function openInmuebleModal()
    {
        $this->resetInmuebleForm();
        $this->selectedInmuebleId = null;
        $this->showInmuebleModal = true;
    }

    public function closeInmuebleModal()
    {
        $this->showInmuebleModal = false;
    }

    private function resetInmuebleForm()
    {
        $this->inmuebleNombre = '';
        $this->inmueblePromocionId = null;
        $this->inmuebleTipoInmuebleId = null;
        $this->inmuebleTipoProteccionId = null;
        $this->inmuebleEstadoId = null;
        $this->inmuebleComentario = '';
        $this->resetErrorBag();
    }

    public function editInmueble($id)
    {
        $this->resetInmuebleForm();
        $this->selectedInmuebleId = $id;

        $inmueble = DB::table('mod110_inmuebles')->where('id', $id)->first();

        if ($inmueble) {
            $this->inmuebleNombre = $inmueble->nombre;
            $this->inmueblePromocionId = $inmueble->promocion_id;
            $this->inmuebleTipoInmuebleId = $inmueble->tipo_inmueble_id;
            $this->inmuebleTipoProteccionId = $inmueble->tipo_proteccion_id;
            $this->inmuebleEstadoId = $inmueble->estado_id;
            $this->inmuebleComentario = $inmueble->comentario;

            $this->showInmuebleModal = true;
        }
    }

    public function saveInmueble()
    {
        $this->validate([
            'inmuebleNombre' => 'required|min:2',
            'inmueblePromocionId' => 'required',
            'inmuebleTipoInmuebleId' => 'required',
        ]);

        try {
            $data = [
                'nombre' => $this->inmuebleNombre,
                'promocion_id' => $this->inmueblePromocionId,
                'tipo_inmueble_id' => $this->inmuebleTipoInmuebleId,
                'tipo_proteccion_id' => $this->inmuebleTipoProteccionId,
                'estado_id' => $this->inmuebleEstadoId,
                'comentario' => $this->inmuebleComentario,
                'updated_at' => now(),
            ];

            if ($this->selectedInmuebleId) {
                DB::table('mod110_inmuebles')->where('id', $this->selectedInmuebleId)->update($data);
                $msg = 'Inmueble actualizado correctamente.';
            } else {
                $data['created_at'] = now();
                DB::table('mod110_inmuebles')->insert($data);
                $msg = 'Inmueble creado correctamente.';
            }

            $this->showInmuebleModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar inmueble: ' . $e->getMessage());
        }
    }

    public function duplicateInmueble($id)
    {
        try {
            DB::beginTransaction();

            $original = DB::table('mod110_inmuebles')->where('id', $id)->first();

            if ($original) {
                $newId = DB::table('mod110_inmuebles')->insertGetId([
                    'nombre' => $original->nombre . ' (Copia)',
                    'promocion_id' => $original->promocion_id,
                    'tipo_inmueble_id' => $original->tipo_inmueble_id,
                    'tipo_proteccion_id' => $original->tipo_proteccion_id,
                    'estado_id' => $original->estado_id,
                    'comentario' => $original->comentario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Duplicado!',
                    'text' => 'Inmueble duplicado correctamente.'
                ]);

                $this->editInmueble($newId);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('swal:alert', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo duplicar el inmueble: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmDeleteInmueble($id)
    {
        $this->inmuebleIdToDelete = $id;
        $this->showDeleteInmuebleModal = true;
    }

    public function deleteInmueble()
    {
        if ($this->inmuebleIdToDelete) {
            try {
                DB::table('mod110_inmuebles')->where('id', $this->inmuebleIdToDelete)->delete();
                $this->showDeleteInmuebleModal = false;
                $this->inmuebleIdToDelete = null;

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Eliminado!',
                    'text' => 'El inmueble ha sido eliminado correctamente.'
                ]);
            } catch (\Exception $e) {
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el inmueble: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function sortInmueblesBy($field)
    {
        if ($this->sortInmuebleField === $field) {
            $this->sortInmuebleDirection = $this->sortInmuebleDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortInmuebleField = $field;
            $this->sortInmuebleDirection = 'asc';
        }
    }


    // --- GESTIÓN DE PROMOCIONES ---

    public function openPromocionModal()
    {
        $this->resetPromocionForm();
        $this->selectedPromocionId = null;
        $this->showPromocionModal = true;
    }

    public function closePromocionModal()
    {
        $this->showPromocionModal = false;
    }

    private function resetPromocionForm()
    {
        $this->promoNombre = '';
        $this->promoCoopId = null;
        $this->promoComentario = '';
        $this->resetErrorBag();
    }

    public function editPromocion($id)
    {
        $this->resetPromocionForm();
        $this->selectedPromocionId = $id;

        $promo = DB::table('mod110_coop_promociones')->where('id', $id)->first();

        if ($promo) {
            $this->promoNombre = $promo->nombre_promocion;
            $this->promoCoopId = $promo->cooperativa_id;
            $this->promoComentario = $promo->comentario;

            $this->showPromocionModal = true;
        }
    }

    public function savePromocion()
    {
        $this->validate([
            'promoNombre' => 'required|min:3',
            'promoCoopId' => 'required',
        ]);

        try {
            $data = [
                'nombre_promocion' => $this->promoNombre,
                'cooperativa_id' => $this->promoCoopId,
                'comentario' => $this->promoComentario,
                'updated_at' => now(),
            ];

            if ($this->selectedPromocionId) {
                DB::table('mod110_coop_promociones')->where('id', $this->selectedPromocionId)->update($data);
                $msg = 'Promoción actualizada correctamente.';
            } else {
                $data['created_at'] = now();
                DB::table('mod110_coop_promociones')->insert($data);
                $msg = 'Promoción creada correctamente.';
            }

            $this->showPromocionModal = false;
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => $msg
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar promoción: ' . $e->getMessage());
        }
    }

    public function confirmDeletePromocion($id)
    {
        $this->promocionIdToDelete = $id;
        $this->showDeletePromocionModal = true;
    }

    public function deletePromocion()
    {
        if ($this->promocionIdToDelete) {
            try {
                // Verificar si tiene inmuebles asociados
                $hasInmuebles = DB::table('mod110_inmuebles')->where('promocion_id', $this->promocionIdToDelete)->exists();

                if ($hasInmuebles) {
                    $this->emit('swal:alert', [
                        'type' => 'error',
                        'title' => 'No se puede eliminar',
                        'text' => 'Esta promoción tiene inmuebles asociados. Elimine primero los inmuebles.'
                    ]);
                    return;
                }

                DB::table('mod110_coop_promociones')->where('id', $this->promocionIdToDelete)->delete();
                $this->showDeletePromocionModal = false;
                $this->promocionIdToDelete = null;

                $this->emit('swal:alert', [
                    'type' => 'success',
                    'title' => '¡Eliminada!',
                    'text' => 'La promoción ha sido eliminada correctamente.'
                ]);
            } catch (\Exception $e) {
                $this->emit('swal:alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la promoción: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function sortPromocionesBy($field)
    {
        if ($this->sortPromocionField === $field) {
            $this->sortPromocionDirection = $this->sortPromocionDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortPromocionField = $field;
            $this->sortPromocionDirection = 'asc';
        }
    }

    public function openMailboxWith($email)
    {
        $this->draftEmail = $email;
        $this->activePage = 'mensajes';
        $this->closeUserDetail();
    }



    public function selectUser($id)
    {
        $this->selectedUserId = $id;
    }

    public function closeUserDetail()
    {
        $this->selectedUserId = null;
    }

    public function openUserModal($id = null)
    {
        $this->selectedUserEditId = $id;

        if ($id) {
            $user = DB::table('users')
                ->leftJoin('personas', 'users.persona_id', '=', 'personas.id')
                ->select('users.*', 'personas.nombre as p_nombre', 'personas.apellidos', 'personas.numero_documento', 'users.persona_id', 'personas.domicilio', 'personas.cpostal', 'personas.provincia', 'personas.poblacion')
                ->where('users.id', $id)
                ->first();

            $this->userNick = $user->nombre;
            $this->userNombre = $user->p_nombre ?? '';
            $this->userApellidos = $user->apellidos ?? '';
            $this->userDNI = $user->numero_documento ?? '';
            $this->userEmail = $user->email ?? '';
            $this->userPuesto = $user->puesto ?? '';
            $this->userDepartamentoId = $user->departamento_id ?? '';
            $this->userDomicilio = $user->domicilio ?? '';
            $this->userCPostal = $user->cpostal ?? '';
            $this->userProvinciaId = $user->provincia ?? '';
            $this->userPoblacionId = $user->poblacion ?? '';

            if ($user->persona_id) {
                // Load phones
                $telfs = DB::table('telefonos')->where('persona_id', $user->persona_id)->orderBy('orden')->get();
                $this->userTelefonos = $telfs->map(function ($t) {
                    return ['telefono' => $t->telefono, 'descripcion' => $t->descripcion ?? ''];
                })->toArray();

                // Load emails
                $emails = DB::table('emails')->where('persona_id', $user->persona_id)->orderBy('orden')->get();
                $this->userEmailsList = $emails->map(function ($e) {
                    return ['email' => $e->email, 'descripcion' => $e->descripcion ?? ''];
                })->toArray();
            } else {
                $this->userTelefonos = [];
                $this->userEmailsList = [];
            }
        } else {
            $this->reset(['userNick', 'userNombre', 'userApellidos', 'userDNI', 'userEmail', 'userPuesto', 'userDepartamentoId', 'userDomicilio', 'userCPostal', 'userProvinciaId', 'userPoblacionId', 'userTelefonos', 'userEmailsList']);
        }

        $this->showUserModal = true;
    }

    public function addUserTelefono()
    {
        $this->userTelefonos[] = ['telefono' => '', 'descripcion' => ''];
    }

    public function removeUserTelefono($index)
    {
        unset($this->userTelefonos[$index]);
        $this->userTelefonos = array_values($this->userTelefonos);
    }

    public function addUserEmail()
    {
        $this->userEmailsList[] = ['email' => '', 'descripcion' => ''];
    }

    public function removeUserEmail($index)
    {
        unset($this->userEmailsList[$index]);
        $this->userEmailsList = array_values($this->userEmailsList);
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->selectedUserEditId = null;
    }

    public function saveUser()
    {
        $this->validate([
            'userNick' => 'required',
            'userNombre' => 'required',
            'userEmail' => 'required|email' . ($this->selectedUserEditId ? '' : '|unique:users,email'),
            'userTelefonos.*.telefono' => 'required',
            'userEmailsList.*.email' => 'required|email'
        ]);

        DB::transaction(function () {
            if ($this->selectedUserEditId) {
                $user = DB::table('users')->where('id', $this->selectedUserEditId)->first();
                $personaId = $user->persona_id;

                if ($personaId) {
                    DB::table('personas')->where('id', $personaId)->update([
                        'nombre' => $this->userNombre,
                        'apellidos' => $this->userApellidos,
                        'numero_documento' => $this->userDNI,
                        'domicilio' => $this->userDomicilio,
                        'cpostal' => $this->userCPostal,
                        'provincia' => $this->userProvinciaId ?: null,
                        'poblacion' => $this->userPoblacionId ?: null,
                        'pais' => 'ESPAÑA',
                        'updated_at' => now(),
                    ]);
                } else {
                    $personaId = DB::table('personas')->insertGetId([
                        'nombre' => $this->userNombre,
                        'apellidos' => $this->userApellidos,
                        'numero_documento' => $this->userDNI,
                        'domicilio' => $this->userDomicilio,
                        'cpostal' => $this->userCPostal,
                        'provincia' => $this->userProvinciaId ?: null,
                        'poblacion' => $this->userPoblacionId ?: null,
                        'pais' => 'ESPAÑA',
                        'created_at' => now(),
                    ]);
                }

                DB::table('users')->where('id', $this->selectedUserEditId)->update([
                    'nombre' => $this->userNick,
                    'email' => $this->userEmail,
                    'puesto' => $this->userPuesto,
                    'departamento_id' => $this->userDepartamentoId ?: null,
                    'persona_id' => $personaId,
                    'updated_at' => now()
                ]);

                // Sync telefonos
                DB::table('telefonos')->where('persona_id', $personaId)->delete();
                foreach ($this->userTelefonos as $i => $tel) {
                    if (!empty($tel['telefono'])) {
                        DB::table('telefonos')->insert([
                            'persona_id' => $personaId,
                            'telefono' => $tel['telefono'],
                            'descripcion' => $tel['descripcion'] ?? null,
                            'orden' => $i + 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Sync emails
                DB::table('emails')->where('persona_id', $personaId)->delete();
                foreach ($this->userEmailsList as $i => $e) {
                    if (!empty($e['email'])) {
                        DB::table('emails')->insert([
                            'persona_id' => $personaId,
                            'email' => $e['email'],
                            'descripcion' => $e['descripcion'] ?? null,
                            'orden' => $i + 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            } else {
                $personaId = DB::table('personas')->insertGetId([
                    'nombre' => $this->userNombre,
                    'apellidos' => $this->userApellidos,
                    'numero_documento' => $this->userDNI,
                    'domicilio' => $this->userDomicilio,
                    'cpostal' => $this->userCPostal,
                    'provincia' => $this->userProvinciaId ?: null,
                    'poblacion' => $this->userPoblacionId ?: null,
                    'pais' => 'ESPAÑA',
                    'created_at' => now(),
                ]);

                $userId = DB::table('users')->insertGetId([
                    'nombre' => $this->userNick,
                    'email' => $this->userEmail,
                    'password' => bcrypt('12345678'), // Default password
                    'puesto' => $this->userPuesto,
                    'departamento_id' => $this->userDepartamentoId ?: null,
                    'persona_id' => $personaId,
                    'created_at' => now()
                ]);

                foreach ($this->userTelefonos as $i => $tel) {
                    if (!empty($tel['telefono'])) {
                        DB::table('telefonos')->insert([
                            'persona_id' => $personaId,
                            'telefono' => $tel['telefono'],
                            'descripcion' => $tel['descripcion'] ?? null,
                            'orden' => $i + 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                foreach ($this->userEmailsList as $i => $e) {
                    if (!empty($e['email'])) {
                        DB::table('emails')->insert([
                            'persona_id' => $personaId,
                            'email' => $e['email'],
                            'descripcion' => $e['descripcion'] ?? null,
                            'orden' => $i + 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        });

        $this->closeUserModal();
        if ($this->selectedUserId == $this->selectedUserEditId) {
            $this->selectedUserId = null;
        }
        $this->emit('userSaved');
    }

    public function confirmDeleteUser($id)
    {
        $this->userIdToDelete = $id;
        $this->showDeleteUserModal = true;
    }

    public function deleteUser()
    {
        if ($this->userIdToDelete) {
            DB::table('users')->where('id', $this->userIdToDelete)->delete();

            if ($this->selectedUserId == $this->userIdToDelete) {
                $this->closeUserDetail();
            }

            $this->showDeleteUserModal = false;
            $this->userIdToDelete = null;
        }
    }

    public function render()
    {
        $cooperativas = [];
        $expectantes = [];
        $registrados = [];
        $sociosCoop = [];
        $inmuebles = [];
        $promocionesList = [];
        $availableExpectantes = [];
        $usersList = [];
        $userToView = null;
        $estados = DB::table('mod110_m_estados_cooperativas')->orderBy('orden_vis')->get();
        $tiposInmueble = DB::table('mod110_m_tipos_inmueble')->orderBy('orden_vis')->get();
        $tiposProteccion = DB::table('mod110_m_tipos_proteccion')->orderBy('orden_vis')->get();
        $estadosInmueble = []; // Definimos como array vacío para evitar error si no existe la tabla maestra

        if ($this->showLinkModal) {
            $linkQuery = DB::table('mod110_expectantes')
                ->join('entidades', 'mod110_expectantes.entidad_id', '=', 'entidades.id')
                ->select('entidades.*');

            if ($this->searchLinkSocio) {
                $linkQuery->where(function ($q) {
                    $q->where('entidades.nombre', 'like', '%' . $this->searchLinkSocio . '%')
                        ->orWhere('entidades.cif', 'like', '%' . $this->searchLinkSocio . '%');
                });
            }

            // Excluir los que ya están en esta cooperativa
            $alreadyJoinedIds = DB::table('mod110_coop_socios')
                ->where('cooperativa_id', $this->selectedCoopIdForMembers)
                ->pluck('entidad_id');

            $availableExpectantes = $linkQuery->whereNotIn('entidades.id', $alreadyJoinedIds)->get();
        }

        if ($this->activePage === 'cooperativas') {
            $query = DB::table('mod110_cooperativas')
                ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
                ->leftJoin('mod110_m_estados_cooperativas', 'mod110_cooperativas.estado_id', '=', 'mod110_m_estados_cooperativas.id')
                ->leftJoin('mod110_m_tipos_inmueble', 'mod110_cooperativas.tipo_inmueble_id', '=', 'mod110_m_tipos_inmueble.id')
                ->leftJoin('mod110_m_tipos_proteccion', 'mod110_cooperativas.tipo_proteccion_id', '=', 'mod110_m_tipos_proteccion.id')
                ->select(
                    'mod110_cooperativas.*',
                    DB::raw('(SELECT COUNT(*) FROM mod110_coop_socios WHERE cooperativa_id = mod110_cooperativas.id AND tipo_socio_id = 1) as num_socios_expectantes'),
                    DB::raw('(SELECT COUNT(*) FROM mod110_coop_socios WHERE cooperativa_id = mod110_cooperativas.id AND tipo_socio_id = 2) as num_socios_registrados'),
                    DB::raw('(SELECT COUNT(*) FROM mod110_coop_socios WHERE cooperativa_id = mod110_cooperativas.id AND tipo_socio_id = 4) as num_socios_espera'),
                    'entidades.nombre',
                    'entidades.activa',
                    'entidades.poblacion',
                    'mod110_m_estados_cooperativas.acronimo as estado_acronimo',
                    'mod110_m_estados_cooperativas.color_tipo as estado_color',
                    'mod110_m_tipos_inmueble.acronimo as inmueble_acronimo',
                    'mod110_m_tipos_inmueble.color_tipo as inmueble_color',
                    'mod110_m_tipos_proteccion.acronimo as proteccion_acronimo',
                    'mod110_m_tipos_proteccion.color_tipo as proteccion_color'
                );

            if (!$this->showFinished) {
                $query->where('entidades.activa', 1);
            }

            if ($this->searchCoop) {
                $query->where(function ($q) {
                    $q->where('entidades.nombre', 'like', '%' . $this->searchCoop . '%')
                        ->orWhere('entidades.poblacion', 'like', '%' . $this->searchCoop . '%')
                        ->orWhere('mod110_cooperativas.registro_cooperativas', 'like', '%' . $this->searchCoop . '%');
                });
            }

            $cooperativas = $query->get();
        } elseif ($this->activePage === 'expectantes') {
            $query = DB::table('mod110_expectantes')
                ->join('entidades', 'mod110_expectantes.entidad_id', '=', 'entidades.id')
                ->select(
                    'mod110_expectantes.*',
                    'entidades.nombre',
                    'entidades.mail_ppal',
                    'entidades.tlf_ppal',
                    'entidades.cif',
                    'mod110_expectantes.id as exp_id'
                );

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('entidades.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('entidades.mail_ppal', 'like', '%' . $this->search . '%')
                        ->orWhere('entidades.cif', 'like', '%' . $this->search . '%');
                });
            }

            $expectantes = $query->orderBy($this->sortField, $this->sortDirection)->get();
        } elseif ($this->activePage === 'socios') {
            // Cargar socios registrados (entidades que tienen al menos una relación en mod110_coop_socios)
            $query = DB::table('entidades')
                ->join('mod110_coop_socios', 'entidades.id', '=', 'mod110_coop_socios.entidad_id')
                ->leftJoin('mod110_m_tipos_socios', 'mod110_coop_socios.tipo_socio_id', '=', 'mod110_m_tipos_socios.id')
                ->select(
                    'entidades.id',
                    'entidades.nombre',
                    'entidades.cif',
                    'entidades.mail_ppal',
                    'entidades.tlf_ppal',
                    'entidades.comentario',
                    DB::raw('COUNT(DISTINCT mod110_coop_socios.cooperativa_id) as num_cooperativas'),
                    DB::raw('GROUP_CONCAT(DISTINCT mod110_m_tipos_socios.acronimo SEPARATOR ", ") as tipos_socio')
                )
                ->groupBy('entidades.id', 'entidades.nombre', 'entidades.cif', 'entidades.mail_ppal', 'entidades.tlf_ppal', 'entidades.comentario');

            if ($this->searchReg) {
                $query->where(function ($q) {
                    $q->where('entidades.nombre', 'like', '%' . $this->searchReg . '%')
                        ->orWhere('entidades.cif', 'like', '%' . $this->searchReg . '%')
                        ->orWhere('entidades.mail_ppal', 'like', '%' . $this->searchReg . '%');
                });
            }

            $registrados = $query->orderBy($this->sortRegField, $this->sortRegDirection)->get();
        } elseif ($this->activePage === 'inmuebles') {
            $query = DB::table('mod110_inmuebles')
                ->leftJoin('mod110_coop_promociones', 'mod110_inmuebles.promocion_id', '=', 'mod110_coop_promociones.id')
                ->leftJoin('mod110_m_tipos_inmueble', 'mod110_inmuebles.tipo_inmueble_id', '=', 'mod110_m_tipos_inmueble.id')
                ->leftJoin('mod110_m_tipos_proteccion', 'mod110_inmuebles.tipo_proteccion_id', '=', 'mod110_m_tipos_proteccion.id')
                ->select(
                    'mod110_inmuebles.*',
                    'mod110_coop_promociones.nombre_promocion as promocion_nombre',
                    'mod110_m_tipos_inmueble.nombre as tipo_inmueble_nombre',
                    'mod110_m_tipos_inmueble.acronimo as inmueble_acronimo',
                    'mod110_m_tipos_inmueble.color_tipo as inmueble_color',
                    'mod110_m_tipos_proteccion.acronimo as proteccion_acronimo',
                    'mod110_m_tipos_proteccion.color_tipo as proteccion_color'
                );

            if ($this->searchInmueble) {
                $query->where(function ($q) {
                    $q->where('mod110_inmuebles.nombre', 'like', '%' . $this->searchInmueble . '%')
                        ->orWhere('mod110_coop_promociones.nombre_promocion', 'like', '%' . $this->searchInmueble . '%');
                });
            }

            if ($this->filterInmuebleTipo) {
                $query->where('mod110_inmuebles.tipo_inmueble_id', $this->filterInmuebleTipo);
            }

            if ($this->filterInmuebleEstado) {
                $query->where('mod110_inmuebles.estado_id', $this->filterInmuebleEstado);
            }

            if ($this->filterInmueblePromo) {
                $query->where('mod110_inmuebles.promocion_id', $this->filterInmueblePromo);
            }

            if ($this->filterInmuebleCoop) {
                $query->where('mod110_coop_promociones.cooperativa_id', $this->filterInmuebleCoop);
            }

            $inmuebles = $query->orderBy($this->sortInmuebleField, $this->sortInmuebleDirection)->get();
        } elseif ($this->activePage === 'promociones') {
            $query = DB::table('mod110_coop_promociones')
                ->join('mod110_cooperativas', 'mod110_coop_promociones.cooperativa_id', '=', 'mod110_cooperativas.id')
                ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
                ->select(
                    'mod110_coop_promociones.*',
                    'entidades.nombre as coop_nombre',
                    DB::raw('(SELECT COUNT(*) FROM mod110_inmuebles WHERE promocion_id = mod110_coop_promociones.id) as num_inmuebles')
                );

            if ($this->searchPromocion) {
                $query->where('mod110_coop_promociones.nombre_promocion', 'like', '%' . $this->searchPromocion . '%')
                    ->orWhere('entidades.nombre', 'like', '%' . $this->searchPromocion . '%');
            }

            $promocionesList = $query->orderBy($this->sortPromocionField, $this->sortPromocionDirection)->get();
        } elseif ($this->activePage === 'contactos') {
            $query = DB::table('users')
                ->leftJoin('mm_departamentos', 'users.departamento_id', '=', 'mm_departamentos.id')
                ->leftJoin('personas', 'users.persona_id', '=', 'personas.id')
                ->select(
                    'users.*',
                    'mm_departamentos.nombre as departamento_nombre',
                    'personas.nombre as p_nombre',
                    'personas.apellidos',
                    DB::raw('(SELECT GROUP_CONCAT(telefono SEPARATOR "<br>") FROM telefonos WHERE telefonos.persona_id = personas.id) as tlf_ppal'),
                    DB::raw('(SELECT GROUP_CONCAT(email SEPARATOR "<br>") FROM emails WHERE emails.persona_id = personas.id) as emails_list'),
                    'personas.numero_documento as cif'
                );

            if ($this->searchUser) {
                $query->where(function ($q) {
                    $q->where('users.nombre', 'like', '%' . $this->searchUser . '%')
                        ->orWhere('users.email', 'like', '%' . $this->searchUser . '%')
                        ->orWhere('personas.numero_documento', 'like', '%' . $this->searchUser . '%');
                });
            }

            if ($this->activeUserFilter !== 'all') {
                $query->where('mm_departamentos.nombre', $this->activeUserFilter);
            }

            if ($this->userPerPage === 'all') {
                $usersList = $query->get();
            } else {
                $usersList = $query->paginate($this->userPerPage);
            }

            if ($this->selectedUserId) {
                $userToView = DB::table('users')
                    ->leftJoin('mm_departamentos', 'users.departamento_id', '=', 'mm_departamentos.id')
                    ->leftJoin('personas', 'users.persona_id', '=', 'personas.id')
                    ->leftJoin('m_provincias', 'personas.provincia', '=', 'm_provincias.id')
                    ->leftJoin('m_municipios', 'personas.poblacion', '=', 'm_municipios.id')
                    ->select(
                        'users.*',
                        'mm_departamentos.nombre as departamento_nombre',
                        'personas.nombre as p_nombre',
                        'personas.apellidos',
                        'personas.domicilio',
                        'm_municipios.nombre as poblacion_nombre',
                        'm_provincias.provincia as provincia_nombre',
                        'personas.cpostal',
                        DB::raw('(SELECT GROUP_CONCAT(telefono SEPARATOR "<br>") FROM telefonos WHERE telefonos.persona_id = personas.id) as tlf_ppal'),
                        DB::raw('(SELECT GROUP_CONCAT(email SEPARATOR "<br>") FROM emails WHERE emails.persona_id = personas.id) as emails_list'),
                        'personas.numero_documento as cif'
                    )
                    ->where('users.id', $this->selectedUserId)
                    ->first();
            }
        }

        // Cargar cooperativas de un socio específico
        $socioCoops = [];
        if ($this->showSocioCoopsModal && $this->selectedSocioIdForCoops) {
            $socioCoops = DB::table('mod110_coop_socios')
                ->join('mod110_cooperativas', 'mod110_coop_socios.cooperativa_id', '=', 'mod110_cooperativas.id')
                ->join('entidades as coop_entidades', 'mod110_cooperativas.entidad_id', '=', 'coop_entidades.id')
                ->leftJoin('mod110_m_tipos_socios', 'mod110_coop_socios.tipo_socio_id', '=', 'mod110_m_tipos_socios.id')
                ->leftJoin('mod110_m_estados_cooperativas', 'mod110_cooperativas.estado_id', '=', 'mod110_m_estados_cooperativas.id')
                ->where('mod110_coop_socios.entidad_id', $this->selectedSocioIdForCoops)
                ->select(
                    'mod110_cooperativas.id as coop_id',
                    'coop_entidades.nombre as coop_nombre',
                    'mod110_cooperativas.registro_cooperativas',
                    'mod110_m_tipos_socios.nombre as tipo_socio',
                    'mod110_m_tipos_socios.acronimo as tipo_socio_acronimo',
                    'mod110_m_tipos_socios.color_tipo as tipo_socio_color',
                    'mod110_m_estados_cooperativas.acronimo as estado_acronimo',
                    'mod110_m_estados_cooperativas.color_tipo as estado_color'
                )
                ->get();
        }

        if ($this->showMembersModal && $this->selectedCoopIdForMembers) {
            $memberQuery = DB::table('mod110_coop_socios')
                ->join('entidades', 'mod110_coop_socios.entidad_id', '=', 'entidades.id')
                ->leftJoin('mod110_m_tipos_socios', 'mod110_coop_socios.tipo_socio_id', '=', 'mod110_m_tipos_socios.id')
                ->where('mod110_coop_socios.cooperativa_id', $this->selectedCoopIdForMembers)
                ->select(
                    'mod110_coop_socios.id as socio_table_id',
                    'mod110_coop_socios.tipo_socio_id',
                    'mod110_m_tipos_socios.nombre as tipo_socio_nombre',
                    'mod110_m_tipos_socios.acronimo as tipo_socio_acronimo',
                    'mod110_m_tipos_socios.color_tipo as tipo_socio_color',
                    'entidades.*'
                );

            if ($this->searchMember) {
                $memberQuery->where(function ($q) {
                    $q->where('entidades.nombre', 'like', '%' . $this->searchMember . '%')
                        ->orWhere('entidades.cif', 'like', '%' . $this->searchMember . '%')
                        ->orWhere('entidades.mail_ppal', 'like', '%' . $this->searchMember . '%');
                });
            }

            $sociosCoop = $memberQuery->orderBy($this->sortMemberField, $this->sortMemberDirection)->get();
        }

        return view('livewire.desktop', [
            'cooperativas' => $cooperativas,
            'expectantes' => $expectantes,
            'registrados' => $registrados ?? [],
            'estados' => $estados,
            'sociosCoop' => $sociosCoop,
            'socioCoops' => $socioCoops,
            'availableExpectantes' => $availableExpectantes,
            'tiposInmueble' => $tiposInmueble,
            'tiposProteccion' => $tiposProteccion,
            'estadosInmueble' => $estadosInmueble,
            'inmuebles' => $inmuebles ?? [],
            'promocionesList' => $promocionesList ?? [],
            'promociones' => DB::table('mod110_coop_promociones')
                ->join('mod110_cooperativas', 'mod110_coop_promociones.cooperativa_id', '=', 'mod110_cooperativas.id')
                ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
                ->select('mod110_coop_promociones.*', 'entidades.nombre as coop_nombre')
                ->get(),
            'cooperativasList' => DB::table('mod110_cooperativas')
                ->join('entidades', 'mod110_cooperativas.entidad_id', '=', 'entidades.id')
                ->select('mod110_cooperativas.id', 'entidades.nombre')
                ->where('entidades.activa', 1)
                ->get(),
            'tiposArchivo' => DB::table('m_tipos_archivo')->orderBy('nombre')->get(),
            'usersList' => $usersList,
            'userToView' => $userToView ?? null,
            'departamentosList' => DB::table('mm_departamentos')->orderBy('nombre')->get(),
            'provinciasList' => DB::table('m_provincias')->orderBy('provincia')->get(),
            'municipiosList' => $this->userProvinciaId ? DB::table('m_municipios')->where('provincia_id', $this->userProvinciaId)->orderBy('nombre')->get() : [],
        ])->layout('layouts.app');
    }
}
