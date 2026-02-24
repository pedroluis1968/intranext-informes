{{-- Modales de confirmación: Desvincular Socio, Inscribir Expectante, File Upload, Delete --}}

<!-- Modal de Confirmación de Desvinculación -->
@if($showUnlinkModal)
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
                    <h5 class="fw-bold">¿Desvincular Socio?</h5>
                    <p class="text-muted small">El socio dejará de pertenecer a la cooperativa, pero sus datos se
                        mantendrán en el sistema.</p>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-danger rounded-pill py-2 fw-bold" wire:click="unlinkMember">Confirmar
                            Desvinculación</button>
                        <button class="btn btn-link text-muted fw-bold text-decoration-none"
                            wire:click="$set('showUnlinkModal', false)">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Inscripción de Expectante a Solicitante -->
@if($showInscribirModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(40, 167, 69, 0.1) !important; backdrop-filter: blur(8px) !important; z-index: 2200 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2201 !important; max-width: 600px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <!-- Cabecera -->
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-pencil-square fs-3" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">Inscripción de Socio</h5>
                        <p class="text-white-50 small mb-0">Conversión de Expectante a Solicitante</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto"
                        wire:click="$set('showInscribirModal', false)"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Información del Socio -->
                    <div class="alert alert-info border-0 mb-4" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Socio a Inscribir</h6>
                                <p class="mb-0 small">{{ $socioNombreToInscribir }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Proceso -->
                    <div class="bg-light p-4 rounded-4 mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-arrow-right-circle me-2 text-success"></i>
                            ¿Qué sucederá al inscribir este socio?
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>El socio cambiará de <strong class="text-primary">Expectante</strong> a <strong
                                        class="text-success">Solicitante</strong></small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Se actualizarán automáticamente los contadores de la cooperativa</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Podrá proceder con la generación del contrato de solicitud de ingreso</small>
                            </li>
                        </ul>
                    </div>

                    <!-- Mensaje de Advertencia -->
                    <div class="alert alert-warning border-0 mb-0" style="border-radius: 15px;">
                        <div class="d-flex">
                            <i class="bi bi-exclamation-triangle-fill me-3 mt-1"></i>
                            <small class="mb-0">
                                Esta acción modificará el estado del socio. Asegúrese de que el socio ha manifestado su
                                intención de solicitar el ingreso formalmente en la cooperativa.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Footer con Acciones -->
                <div class="modal-footer border-0 p-4 d-flex justify-content-between" style="background: #f8f9fa;">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none"
                        wire:click="$set('showInscribirModal', false)">
                        Cancelar
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold"
                            wire:click="abrirFormularioContrato">
                            <i class="bi bi-file-earmark-text me-2"></i>Formulario de Contrato
                        </button>
                        <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow"
                            wire:click="inscribirSocio">
                            <i class="bi bi-check-circle me-2"></i>Confirmar Inscripción
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Subida de Documentos -->
@if($showUploadFileModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(54, 179, 126, 0.1) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 700px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #36b37e 0%, #00875a 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-file-earmark-arrow-up fs-3" style="color: #36b37e;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">Subir Documento</h5>
                        <p class="text-white-50 small mb-0">Socio: {{ $selectedEntidadNameForFile }}</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto"
                        wire:click="closeUploadFileModal"></button>
                </div>

                <form wire:submit.prevent="saveFile">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <!-- Zona de carga de archivo -->
                            <div class="col-12">
                                <div class="p-4 border-2 border-dashed rounded-4 text-center @if($uploadedFile) bg-success bg-opacity-10 border-success @else bg-light border-secondary border-opacity-25 @endif shadow-sm position-relative"
                                    style="transition: all 0.3s ease;">
                                    @if($uploadedFile)
                                        <i class="bi bi-file-check-fill text-success fs-1 mb-2"></i>
                                        <div class="fw-bold text-success">{{ $uploadedFile->getClientOriginalName() }}</div>
                                        <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none mt-2"
                                            wire:click="$set('uploadedFile', null)">Cambiar archivo</button>
                                    @else
                                        <i class="bi bi-cloud-arrow-up text-muted fs-1 mb-2"></i>
                                        <div class="small fw-bold text-dark mt-2">Haga clic o arrastre el archivo aquí</div>
                                        <div class="x-small text-muted mb-3">PDF, JPG, PNG, DOC (Máx. 10MB)</div>
                                        <input type="file" id="uploadedFile" class="position-absolute opacity-0"
                                            style="cursor: pointer; width: 100%; top: 0; left: 0; height: 100%;"
                                            wire:model="uploadedFile">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-4"
                                            onclick="document.getElementById('uploadedFile').click()">Seleccionar
                                            Archivo</button>
                                    @endif
                                </div>
                                @error('uploadedFile') <span class="text-danger x-small d-block mt-2">{{ $message }}</span>
                                @enderror

                                <!-- Barra de progreso Livewire -->
                                <div wire:loading wire:target="uploadedFile" class="w-100 mt-2">
                                    <div class="progress" style="height: 6px; border-radius: 3px;">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped bg-info"
                                            style="width: 100%"></div>
                                    </div>
                                    <div class="text-center x-small text-muted mt-1">Cargando archivo...</div>
                                </div>
                            </div>

                            <!-- Datos del archivo -->
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold small text-muted">Nombre del Documento</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="fileNombre"
                                    placeholder="Ej: Contrato de Adhesión, DNI Escaneado...">
                                @error('fileNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Tipo de Documento</label>
                                <select class="form-select border-light shadow-sm" style="border-radius: 10px;"
                                    wire:model.defer="fileTipoArchivoId">
                                    <option value="">-- Seleccionar Tipo --</option>
                                    @if(isset($tiposArchivo))
                                        @foreach($tiposArchivo as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('fileTipoArchivoId') <span class="text-danger x-small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Descripción (Opcional)</label>
                                <textarea class="form-control border-light shadow-sm" style="border-radius: 15px;" rows="2"
                                    wire:model.defer="fileDescripcion"
                                    placeholder="Breve detalle sobre el contenido..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeUploadFileModal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold shadow text-white"
                            style="background: linear-gradient(90deg, #36b37e, #00b894); border: none;"
                            wire:loading.attr="disabled" wire:target="uploadedFile">
                            <span wire:loading.remove wire:target="saveFile">
                                <i class="bi bi-cloud-check me-2"></i>Vincular Documento
                            </span>
                            <span wire:loading wire:target="saveFile">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>Guardando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Borrado (Expectante) -->
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

<!-- Modal de Confirmación de Borrado Cooperativa -->
@if($showDeleteCoopModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2100 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2101 !important;">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Eliminar Cooperativa</h4>
                    <p class="text-muted">¿Está seguro de que desea eliminar la cooperativa seleccionada y todos sus datos
                        asociados? Esta acción no se puede deshacer.</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            wire:click="$set('showDeleteCoopModal', false)">Cancelar</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"
                            wire:click="deleteCooperativa">
                            <i class="bi bi-trash me-2"></i>Sí, Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de Confirmación de Borrado (Usuario) -->
@if($showDeleteUserModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(0, 0, 0, 0.5) !important; backdrop-filter: blur(4px) !important; z-index: 2100 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 2101 !important;">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="bi bi-person-x-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Eliminar Usuario</h4>
                    <p class="text-muted">¿Estás seguro de que deseas eliminar este usuario de forma permanente?</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            wire:click="$set('showDeleteUserModal', false)">Cancelar</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"
                            wire:click="deleteUser">
                            <i class="bi bi-trash me-2"></i>Sí, Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif