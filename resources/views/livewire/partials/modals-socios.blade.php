<!-- Modal de Socios Registrados Premium -->
@if($showRegModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(54, 179, 126, 0.15) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 800px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Verde -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #36b37e 0%, #00875a 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-person-check-fill fs-3" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">
                            {{ $selectedRegId ? 'Editar Socio Registrado' : 'Nuevo Socio Registrado' }}
                        </h5>
                        <p class="text-white-50 small mb-0">Gestione los datos del socio activo en cooperativas.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" wire:click="closeRegModal"></button>
                </div>

                <form wire:submit.prevent="saveRegistrado">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Datos Personales -->
                            @if(!$selectedRegId)
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Nombre</label>
                                    <input type="text" class="form-control border-light shadow-sm py-2"
                                        style="border-radius: 10px;" wire:model.defer="regNombre" placeholder="Nombre de pila">
                                    @error('regNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Apellidos</label>
                                    <input type="text" class="form-control border-light shadow-sm py-2"
                                        style="border-radius: 10px;" wire:model.defer="regApellidos"
                                        placeholder="Apellidos completos">
                                </div>
                            @else
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Nombre y Apellidos</label>
                                    <input type="text" class="form-control border-light shadow-sm py-2"
                                        style="border-radius: 10px;" wire:model.defer="regNombre"
                                        placeholder="Nombre y Apellidos completos">
                                    @error('regNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                                </div>
                            @endif
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">DNI / NIE</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="regDNI" placeholder="12345678X">
                                @error('regDNI') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-muted">Correo Electrónico</label>
                                <input type="email" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="regEmail"
                                    placeholder="ejemplo@correo.com">
                                @error('regEmail') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Teléfono Principal</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="regTelefono"
                                    placeholder="+34 600 000 000">
                                @error('regTelefono') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Comentarios y Observaciones</label>
                                <textarea class="form-control border-light shadow-sm" style="border-radius: 15px;" rows="4"
                                    wire:model.defer="regComentario"
                                    placeholder="Notas adicionales sobre el socio..."></textarea>
                            </div>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeRegModal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold shadow text-white"
                            style="background: linear-gradient(90deg, #36b37e, #00b894); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedRegId ? 'Registrar Modificaciones' : 'Guardar Socio Registrado' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Eliminación de Socio Registrado -->
@if($showDeleteRegModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(220, 53, 69, 0.1) !important; backdrop-filter: blur(8px) !important; z-index: 2200 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2201 !important; max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-exclamation-triangle fs-2"></i>
                    </div>
                    <h5 class="fw-bold">¿Eliminar Socio Registrado?</h5>
                    <p class="text-muted small">El socio será eliminado del sistema. Esta acción no se puede deshacer.
                    </p>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-danger rounded-pill py-2 fw-bold" wire:click="deleteRegistrado">Confirmar
                            Eliminación</button>
                        <button class="btn btn-link text-muted fw-bold text-decoration-none"
                            wire:click="$set('showDeleteRegModal', false)">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Cooperativas del Socio -->
@if($showSocioCoopsModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(54, 179, 126, 0.15) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #36b37e 0%, #00875a 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-building-fill fs-3" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">Cooperativas de:
                            {{ $selectedSocioNameForCoops }}
                        </h5>
                        <p class="text-white-50 small mb-0">Visualice las cooperativas en las que participa este socio.
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto"
                        wire:click="closeSocioCoopsModal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="table-responsive bg-white rounded-4 shadow-sm border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Cooperativa</th>
                                    <th class="py-3">Registro</th>
                                    <th class="py-3">Tipo de Socio</th>
                                    <th class="py-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($socioCoops as $coop)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $coop->coop_nombre }}</div>
                                        </td>
                                        <td><span
                                                class="badge bg-light text-dark border">{{ $coop->registro_cooperativas ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if($coop->tipo_socio_acronimo)
                                                <span class="badge shadow-sm text-white"
                                                    style="background-color: {{ $coop->tipo_socio_color ?? '#6c757d' }}; font-size: 0.75rem; padding: 6px 12px;">
                                                    {{ $coop->tipo_socio_acronimo }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($coop->estado_acronimo)
                                                <span class="badge shadow-sm text-white"
                                                    style="background-color: {{ $coop->estado_color ?? '#6c757d' }}; font-size: 0.75rem; padding: 6px 12px;">
                                                    {{ $coop->estado_acronimo }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Este socio no está vinculado a ninguna cooperativa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                    <button type="button" class="btn btn-secondary rounded-pill px-5 fw-bold"
                        wire:click="closeSocioCoopsModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endif