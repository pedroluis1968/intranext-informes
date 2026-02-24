<div class="min-vh-100 d-flex align-items-center justify-content-center p-3"
    style="background-image: url(https://acceso2.intranext.es/images/fondo/LoginFondo.png); background-size: cover; background-position: center;">

    <style>
        .form-control::placeholder {
            color: #b0bec5 !important;
            opacity: 0.7;
            font-weight: 300;
        }

        /* Para navegadores antiguos */
        .form-control::-webkit-input-placeholder {
            color: #b0bec5 !important;
        }

        .form-control::-moz-placeholder {
            color: #b0bec5 !important;
        }

        .form-control:-ms-input-placeholder {
            color: #b0bec5 !important;
        }

        /* Pegar más la etiqueta al campo */
        .form-label {
            margin-bottom: 0.25rem !important;
        }
    </style>

    <div class="card border-0" style="max-width: 960px; width: 100%; border-radius: 24px; overflow: hidden; background-color: #e0f7f6; 
               box-shadow: 0 0 30px rgba(0, 209, 224, 0.3), 15px 15px 35px rgba(0, 0, 0, 0.4);">

        @if($success)
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-3">¡Inscripción Realizada!</h2>
                <p class="text-muted mb-4">Gracias por tu confianza. Hemos enviado un correo de bienvenida a tu dirección de
                    email con la información inicial.</p>
                <button wire:click="$set('success', false)" class="btn btn-primary rounded-pill px-5 py-2 fw-bold"
                    style="background: linear-gradient(90deg, #042a3c, #0d4a66); border: none;">Volver al
                    formulario</button>
            </div>
        @else
            <!-- Cabecera con degradado corporativo -->
            <div class="p-4 text-center d-flex justify-content-center align-items-center gap-4"
                style="background: linear-gradient(90deg, #042a3c, #0d4a66);">
                <div
                    style="background: rgba(255, 255, 255, 0.95); width: 220px; height: 110px; border-radius: 16px; display: flex; align-items: center; justify-content: center; padding: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    <img src="/imagenes/logo-axis-gestora_600.png" alt="Axis Gestora"
                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <div
                    style="background: rgba(255, 255, 255, 0.95); width: 220px; height: 110px; border-radius: 16px; display: flex; align-items: center; justify-content: center; padding: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    <img src="/imagenes/logo-mirador-batres_600.png" alt="Mirador"
                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <h2 class="fw-bold mb-3 text-center" style="color: #042a3c;">Inscripción en el Registro de Socios
                    Expectantes</h2>

                <div class="alert alert-info py-2 px-3 mb-4 border-0 d-flex align-items-center"
                    style="background-color: rgba(4, 42, 60, 0.1); border-radius: 12px; color: #042a3c;">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <span class="small fw-bold">Por favor, rellene todos los campos de este formulario. Todos los datos
                        marcados son obligatorios para tramitar su solicitud.</span>
                </div>

                <p class="mb-4" style="text-align: justify; color: #4a5568; line-height: 1.6;">
                    Cumplimenta tus datos para inscribirte en nuestro registro y mantenerte informado de las promociones de
                    viviendas en régimen de cooperativa que tenemos disponible para ti. La inscripción sólo nos autoriza a
                    enviarte la información correspondiente, y exclusivamente a tal fin conservaremos tus datos. La
                    inscripción no compromente en absoluto a la compra de ningún tipo de bien o servicio.
                </p>

                <form wire:submit.prevent="registrar">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nombre</label>
                            <input type="text" wire:model.defer="nombre" class="form-control border-white py-2 shadow-sm"
                                style="border-radius: 10px;" placeholder="Tu nombre">
                            @error('nombre') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Apellidos</label>
                            <input type="text" wire:model.defer="apellidos" class="form-control border-white py-2 shadow-sm"
                                style="border-radius: 10px;" placeholder="Tus apellidos">
                            @error('apellidos') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">DNI / NIE</label>
                            <input type="text" wire:model.defer="dni" class="form-control border-white py-2 shadow-sm"
                                style="border-radius: 10px;" placeholder="12345678X">
                            @error('dni') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Teléfono</label>
                            <input type="text" wire:model.defer="telefono" class="form-control border-white py-2 shadow-sm"
                                style="border-radius: 10px;" placeholder="+34 600 000 000">
                            @error('telefono') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Correo Electrónico</label>
                            <input type="email" wire:model.defer="email" class="form-control border-white py-2 shadow-sm"
                                style="border-radius: 10px;" placeholder="ejemplo@correo.com">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Observaciones / Preferencias</label>
                            <textarea wire:model.defer="comentario" class="form-control border-white shadow-sm"
                                style="border-radius: 15px;" rows="3"
                                placeholder="Zonas de interés, tipo de vivienda..."></textarea>
                            @error('comentario') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if(session()->has('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow"
                            style="background: linear-gradient(90deg, #042a3c, #0d4a66); border: none; padding: 12px;">
                            <span wire:loading.remove>Enviar Solicitud</span>
                            <span wire:loading>Procesando...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>