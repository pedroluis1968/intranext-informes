<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends Component
{
    public $empresa = '159';
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
        'empresa' => 'required',
    ];

    public function login()
    {
        $this->validate();

        try {
            $user = User::where('email', $this->email)->first();

            if ($user && Hash::check($this->password, $user->password)) {
                Auth::login($user);
                session()->regenerate();
                return redirect()->route('desktop');
            } else {
                $this->dispatchBrowserEvent('swal:error', [
                    'title' => 'Acceso Denegado',
                    'text' => 'Usuario o contraseña incorrectos.',
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error de Acceso',
                'text' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}
