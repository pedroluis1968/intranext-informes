<div class="page-content d-flex flex-column justify-content-between login-page"
    style="background-image: url(https://acceso2.intranext.es/images/fondo/LoginFondo.png);">

    <div class="text-center">
        <img src="https://acceso2.intranext.es/images/logos/logo-intranext-login.png" alt="Logo Intranext"
            class="login-logo pb-0" style="width: 280px;">

        <div class="d-flex justify-content-center align-items-center gap-4 mb-4 mt-n2 px-3 flex-wrap">
            <div
                style="background: rgba(255, 255, 255, 0.9); width: 155px; height: 85px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; padding: 10px;">
                <img src="/imagenes/logo-axis-gestora_600.png" alt="Logo Intranext"
                    style="max-width: 100%; max-height: 100%; height: auto; width: auto; display: block;">
            </div>
            <div
                style="background: rgba(255, 255, 255, 0.9); width: 155px; height: 85px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; padding: 10px;">
                <img src="/imagenes/logo-mirador-batres_600.png" alt="Logo Mirador"
                    style="max-width: 100%; max-height: 100%; height: auto; width: auto; display: block;">
            </div>
        </div>
    </div>

    <div class="container flex-grow-1 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="text-center login-welcome mb-4">
                    <h1 style="font-size: 2.5rem;">Bienvenido,</h1>
                    <h2 style="font-size: 1.8rem;">Inicia sesión en tu cuenta.</h2>
                </div>

                <form wire:submit.prevent="login" class="forms-sample login-form">
                    <!-- Fila Nº Empresa -->
                    <div class="row align-items-center empresa-row">
                        <div class="col-6">
                            <div class="empresa-label">
                                <img src="https://acceso2.intranext.es/images/iconos/login/empresasw.png" alt="empresa"
                                    style="width: 30px; height: 30px;">
                                <span class="text-white">Nº Empresa</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="login-input-group mb-0">
                                <input type="text" class="login-input text-center" wire:model="empresa">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <div class="login-input-group">
                            <img src="https://acceso2.intranext.es/images/iconos/login/mail.png" alt="email"
                                class="input-icon">
                            <input type="email" class="login-input" wire:model="email" placeholder="Correo electrónico"
                                required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <div class="login-input-group">
                            <img src="https://acceso2.intranext.es/images/iconos/login/password.png" alt="password"
                                class="input-icon">
                            <input type="password" class="login-input" id="userPassword" wire:model="password"
                                placeholder="Contraseña" required>
                            <img src="https://acceso2.intranext.es/images/iconos/login/password_2-darkblue.png"
                                alt="toggle password" style="width: 20px; cursor: pointer;" onclick="togglePassword()">
                        </div>
                    </div>

                    <script>
                        function togglePassword() {
                            const pwdInput = document.getElementById('userPassword');
                            pwdInput.type = pwdInput.type === 'password' ? 'text' : 'password';
                        }
                    </script>

                    <div class="text-center col-12">
                        <button type="submit" class="btn btn-primary btn-lg w-100 btn-login">
                            Iniciar sesión
                        </button>

                        <div class="mt-3">
                            <a href="#" class="text-white text-decoration-underline" style="font-size: 0.9rem;">
                                Cambiar de Usuario/Empresa
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-auto">
        <div class="row">
            <div class="col-12 text-center login-footer">
                <p class="mb-0">INTRANEXT© 2025 - DESARROLLADO POR
                    <img src="https://acceso2.intranext.es/images/logos/logo-unaweb.png" alt="unaweb">
                </p>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\intranext-informes\resources\views/livewire/auth/login.blade.php ENDPATH**/ ?>