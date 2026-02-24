<!-- Modal de Usuarios / Contactos -->
@if($showUserModal)
    <div class="modal fade show"
        style="display: block !important; background: rgba(101, 84, 192, 0.15) !important; backdrop-filter: blur(12px) !important; z-index: 2000 !important;"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 2001 !important; max-width: 800px;">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); overflow: hidden;">
                <!-- Cabecera Morada -->
                <div class="modal-header border-0 p-4 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #6554c0 0%, #4a3e8c 100%);">
                    <div class="me-3 bg-white rounded-3 p-2">
                        <i class="bi bi-person-badge-fill fs-3" style="color: #6554c0;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0">
                            {{ $selectedUserEditId ? 'Editar Usuario' : 'Nuevo Usuario' }}
                        </h5>
                        <p class="text-white-50 small mb-0">Gestione los datos del usuario para el acceso y su información
                            de contacto.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" wire:click="closeUserModal"></button>
                </div>

                <form wire:submit.prevent="saveUser">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Login Data -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nombre de Usuario (Nick / Acceso)</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userNick"
                                    placeholder="Nombre de login o alias">
                                @error('userNick') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Correo Electrónico</label>
                                <input type="email" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userEmail"
                                    placeholder="ejemplo@correo.com">
                                @error('userEmail') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>

                            <hr class="my-2 text-muted">

                            <!-- Datos Personales -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Nombre (Físico / Persona)</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userNombre" placeholder="Nombre de pila">
                                @error('userNombre') <span class="text-danger x-small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Apellidos (Físico / Persona)</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userApellidos"
                                    placeholder="Apellidos completos">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">DNI / NIE / CIF</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userDNI" placeholder="Documento legal">
                            </div>

                            <!-- Domicilio y Localización -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Domicilio Completo</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userDomicilio"
                                    placeholder="Calle, número, portal, piso...">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold small text-muted">C. Postal</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userCPostal" placeholder="00000">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Provincia (España)</label>
                                <select class="form-select border-light shadow-sm py-2" style="border-radius: 10px;"
                                    wire:model="userProvinciaId">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($provinciasList as $prov)
                                        <option value="{{ $prov->id }}">{{ $prov->provincia }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Población / Municipio</label>
                                <select class="form-select border-light shadow-sm py-2" style="border-radius: 10px;"
                                    wire:model.defer="userPoblacionId" {{ empty($userProvinciaId) ? 'disabled' : '' }}>
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($municipiosList as $mun)
                                        <option value="{{ $mun->id }}">{{ $mun->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Puesto -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Puesto</label>
                                <input type="text" class="form-control border-light shadow-sm py-2"
                                    style="border-radius: 10px;" wire:model.defer="userPuesto"
                                    placeholder="Administrativo, Director...">
                            </div>
                            <!-- Departamento -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Departamento</label>
                                <select class="form-select border-light shadow-sm py-2" style="border-radius: 10px;"
                                    wire:model.defer="userDepartamentoId">
                                    <option value="">-- Seleccione un departamento --</option>
                                    @foreach($departamentosList as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr class="my-4 text-muted">

                            <!-- Teléfonos Múltiples -->
                            <div class="col-md-6 border-end pe-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-bold small text-muted mb-0">Teléfonos Extra</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;"
                                        wire:click="addUserTelefono">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($userTelefonos as $index => $tel)
                                        <div class="d-flex gap-1 align-items-center bg-light p-2 rounded-3 border">
                                            <input type="text"
                                                class="form-control form-control-sm border-0 shadow-none bg-transparent"
                                                wire:model.defer="userTelefonos.{{ $index }}.telefono"
                                                placeholder="Número (+34...)">
                                            <input type="text"
                                                class="form-control form-control-sm border-0 shadow-none bg-transparent border-start"
                                                wire:model.defer="userTelefonos.{{ $index }}.descripcion"
                                                placeholder="Uso (Movil...)">
                                            <button type="button" class="btn btn-sm text-danger"
                                                wire:click="removeUserTelefono({{ $index }})">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    @if(count($userTelefonos) === 0)
                                        <div class="text-muted small fst-italic text-center py-2 bg-light rounded-3">Sin
                                            teléfonos registrados adicionales.</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Emails Múltiples -->
                            <div class="col-md-6 ps-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-bold small text-muted mb-0">Emails Extra</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;"
                                        wire:click="addUserEmail">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($userEmailsList as $index => $em)
                                        <div class="d-flex gap-1 align-items-center bg-light p-2 rounded-3 border">
                                            <input type="email"
                                                class="form-control form-control-sm border-0 shadow-none bg-transparent"
                                                wire:model.defer="userEmailsList.{{ $index }}.email" placeholder="@correo.com">
                                            <input type="text"
                                                class="form-control form-control-sm border-0 shadow-none bg-transparent border-start"
                                                wire:model.defer="userEmailsList.{{ $index }}.descripcion"
                                                placeholder="Uso (Laboral...)">
                                            <button type="button" class="btn btn-sm text-danger"
                                                wire:click="removeUserEmail({{ $index }})">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    @if(count($userEmailsList) === 0)
                                        <div class="text-muted small fst-italic text-center py-2 bg-light rounded-3">Sin emails
                                            registrados adicionales.</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4" style="background: #f1f3f5;">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none me-auto"
                            wire:click="closeUserModal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold shadow text-white"
                            style="background: linear-gradient(90deg, #6554c0, #4a3e8c); border: none;">
                            <i
                                class="bi bi-check-circle me-2"></i>{{ $selectedUserEditId ? 'Guardar Cambios' : 'Crear Usuario' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif