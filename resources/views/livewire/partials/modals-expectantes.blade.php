<!-- Modal de Socios Expectantes Premium -->
@if($showExpModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(255, 152, 0, 0.4) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 800px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Naranja -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #ff9800 0%, #e65100 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-person-plus-fill fs-3" style="color: #ff9800;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">
                            {{ $selectedExpId ? 'Editar Socio Expectante' : 'Nuevo Socio Expectante' }}
                        </h5>
                        <p class="text-white-50 small mb-0">Gestione los datos del interesado en futuras promociones.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" wire:click="closeExpModal"></button>
                </div>

                <form wire:submit.prevent="saveExpectante">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Nombre y Apellidos</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="expNombre"
                                    placeholder="Nombre completo del interesado">
                                @error('expNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">DNI / NIE</label>
                                <input type="text" class="form-control border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="expDNI" placeholder="00000000A">
                                @error('expDNI') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold small text-muted">Correo Electrónico</label>
                                <input type="email" class="form-control border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="expEmail" placeholder="ejemplo@correo.com">
                                @error('expEmail') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Teléfono Principal</label>
                                <input type="text" class="form-control border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="expTelefono">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Intereses y Comentarios</label>
                                <textarea class="form-control border-light shadow-sm" style="border-radius: 15px;" rows="4"
                                    wire:model.defer="expComentarios"
                                    placeholder="Zonas de interés, tipología de vivienda preferida..."></textarea>
                            </div>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #fff8f0;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeExpModal">Cancelar</button>
                        <button type="submit" class="btn btn-warning rounded-pill px-5 py-2 fw-bold shadow text-dark"
                            style="background: linear-gradient(90deg, #ff9800, #e65100); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedExpId ? 'Registrar Modificaciones' : 'Guardar Socio Expectante' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Borrado -->
@if($showDeleteModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2100 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2101 !important;">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">¿Estás seguro?</h4>
                    <p class="text-muted">Esta acción eliminará permanentemente el registro del socio expectante y no se
                        podrá deshacer.</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            wire:click="$set('showDeleteModal', false)">Cancelar</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold"
                            wire:click="deleteExpectante">
                            <i class="bi bi-trash me-2"></i>Eliminar Registro
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif