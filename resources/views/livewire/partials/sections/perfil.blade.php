{{-- Vista: Perfil de Usuario --}}
<div class="row g-4 justify-content-center">
    <div class="col-md-8">
        <div class="widget-card p-0" style="border: 2px solid #042a3c; box-shadow: 8px 8px 15px rgba(4, 42, 60, 0.3);">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white"
                style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #042a3c;">Mi Perfil</h5>
            </div>
            <div class="p-4 bg-white" style="border-radius: 0 0 16px 16px;">
                <form wire:submit.prevent="updatePerfil" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <div class="position-relative d-inline-block">
                                @if ($perfilAvatar)
                                    <img src="{{ $perfilAvatar->temporaryUrl() }}" class="rounded-circle shadow"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f8f9fa;">
                                @else
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://acceso2.intranext.es/assets/images/avatares/mujer_azul.png' }}"
                                        class="rounded-circle shadow"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f8f9fa;">
                                @endif
                            </div>

                            <!-- Botones explícitos de archivo vs cámara para móviles -->
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <div>
                                    <label for="avatarGallery"
                                        class="btn btn-outline-primary shadow-sm rounded-pill fw-bold"
                                        style="cursor: pointer;">
                                        <i class="bi bi-images me-2"></i>Galería
                                    </label>
                                    <input type="file" id="avatarGallery" class="d-none" wire:model="perfilAvatar"
                                        accept="image/*">
                                </div>

                                <!-- Botón que obliga a abrir la cámara (dependiendo de SO en móvil) -->
                                <div>
                                    <label for="avatarCamera" class="btn btn-primary shadow-sm rounded-pill fw-bold"
                                        style="cursor: pointer;">
                                        <i class="bi bi-camera me-2"></i>Cámara
                                    </label>
                                    <input type="file" id="avatarCamera" class="d-none" wire:model="perfilAvatar"
                                        accept="image/*" capture="environment">
                                </div>
                            </div>
                            @error('perfilAvatar') <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="perfilAvatar" class="text-primary mt-2">
                                Subiendo...
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Nombre del Usuario <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="perfilNombre"
                                placeholder="Tu nombre">
                            @error('perfilNombre') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold border-bottom pb-2">Cambiar Contraseña</h6>
                            <p class="text-muted small">Deja estos campos en blanco si no deseas cambiar tu contraseña.
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nueva Contraseña</label>
                            <input type="password" class="form-control" wire:model.defer="perfilPassword"
                                placeholder="Mínimo 6 caracteres">
                            @error('perfilPassword') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Confirmar Contraseña</label>
                            <input type="password" class="form-control" wire:model.defer="perfilPasswordConfirmation"
                                placeholder="Repite la contraseña">
                        </div>
                    </div>


                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm fw-bold">
                            <i class="bi bi-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>