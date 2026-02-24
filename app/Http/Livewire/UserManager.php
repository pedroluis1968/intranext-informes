<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class UserManager extends Component
{
    public $users = [];
    public $search = ''; // Propiedad para el buscador
    public $error_msg;

    public function render()
    {
        try {
            $query = DB::connection('mysql')->table('users');

            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('puesto', 'like', '%' . $this->search . '%');
                });
            }

            $this->users = $query->get();
            $this->error_msg = null;
        } catch (\Exception $e) {
            $this->users = [];
            $this->error_msg = "Error de conexión: " . $e->getMessage();
        }

        return view('livewire.user-manager');
    }
}
