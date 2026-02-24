<!-- Modal de Promociones Premium -->
@if($showPromocionModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(212, 18, 179, 0.4) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 800px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Fucsia -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #ff00ff 0%, #d412b3 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-layers-fill fs-3" style="color: #ff00ff;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">
                            {{ $selectedPromocionId ? 'Editar Promoción' : 'Nueva Promoción' }}
                        </h5>
                        <p class="text-white-50 small mb-0">Gestione los datos de la promoción inmobiliaria.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto"
                        wire:click="closePromocionModal"></button>
                </div>

                <form wire:submit.prevent="savePromocion">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Nombre de la Promoción</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="promoNombre"
                                    placeholder="Ej: Residencial Los Olivos, Edificio Centro...">
                                @error('promoNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Cooperativa Responsable</label>
                                <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="promoCoopId">
                                    <option value="">-- Seleccionar Cooperativa --</option>
                                    @foreach($cooperativasList as $coop)
                                        <option value="{{ $coop->id }}">{{ $coop->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('promoCoopId') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Descripción / Comentarios</label>
                                <textarea class="form-control border-light shadow-sm" style="border-radius: 15px;" rows="4"
                                    wire:model.defer="promoComentario"
                                    placeholder="Detalles adicionales sobre la promoción..."></textarea>
                            </div>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #f8f9fa;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closePromocionModal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold shadow text-white"
                            style="background: linear-gradient(90deg, #ff00ff, #d412b3); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedPromocionId ? 'Actualizar Promoción' : 'Crear Promoción' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Eliminación Promoción -->
@if($showDeletePromocionModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2200 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2201 !important; max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">¿Eliminar Promoción?</h5>
                    <p class="text-muted small">Esta acción no se puede deshacer. Solo podrá eliminar promociones que no
                        tengan inmuebles vinculados.</p>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-danger rounded-pill py-2 fw-bold shadow-sm"
                            wire:click="deletePromocion">Confirmar Eliminación</button>
                        <button class="btn btn-link text-muted fw-bold text-decoration-none"
                            wire:click="$set('showDeletePromocionModal', false)">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif