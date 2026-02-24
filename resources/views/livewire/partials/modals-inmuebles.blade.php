<!-- Modal de Inmuebles Premium -->
@if($showInmuebleModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(165, 42, 42, 0.4) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 800px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Marrón Rojizo -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #ff5722 0%, #e64a19 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-houses-fill fs-3" style="color: #ff5722;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">
                            {{ $selectedInmuebleId ? 'Editar Inmueble' : 'Nuevo Inmueble' }}
                        </h5>
                        <p class="text-white-50 small mb-0">Registre las características técnicas y ubicación del inmueble.
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto"
                        wire:click="closeInmuebleModal"></button>
                </div>

                <form wire:submit.prevent="saveInmueble">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Nombre / Identificador</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="inmuebleNombre"
                                    placeholder="Ej: Vivienda 1A, Local Bajo Izq...">
                                @error('inmuebleNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Promoción de Pertenencia</label>
                                <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="inmueblePromocionId">
                                    <option value="">-- Seleccionar Promoción --</option>
                                    @foreach($promociones as $promo)
                                        <option value="{{ $promo->id }}">{{ $promo->nombre_promocion }}
                                            ({{ $promo->coop_nombre }})</option>
                                    @endforeach
                                </select>
                                @error('inmueblePromocionId') <span class="text-danger x-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Tipología de Inmueble</label>
                                <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="inmuebleTipoInmuebleId">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($tiposInmueble as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('inmuebleTipoInmuebleId') <span class="text-danger x-small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Tipo de Protección</label>
                                <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="inmuebleTipoProteccionId">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($tiposProteccion as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Observaciones y Memoria</label>
                                <textarea class="form-control border-light shadow-sm" style="border-radius: 15px;" rows="4"
                                    wire:model.defer="inmuebleComentario"
                                    placeholder="Detalles sobre metros cuadrados, anexos, etc."></textarea>
                            </div>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeInmuebleModal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold shadow text-white"
                            style="background: linear-gradient(90deg, #ff5722, #e64a19); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedInmuebleId ? 'Registrar Cambios' : 'Guardar Inmueble' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Eliminación Inmueble -->
@if($showDeleteInmuebleModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2200 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2201 !important; max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-trash-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">¿Eliminar Inmueble?</h5>
                    <p class="text-muted small">Esta acción es irreversible y desvinculará el inmueble de su promoción.</p>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-danger rounded-pill py-2 fw-bold shadow-sm"
                            wire:click="deleteInmueble">Eliminar Permanentemente</button>
                        <button class="btn btn-link text-muted fw-bold text-decoration-none"
                            wire:click="$set('showDeleteInmuebleModal', false)">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif