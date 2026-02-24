{{-- Vista: Usuarios Glassmorphic (antes Contactos) --}}
<div class="contacts-glass-wrapper">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/contacts-glass.css') }}">
    
    <div class="contacts-glass-main">
        <!-- Header search -->
        <header class="glass-card flex items-center justify-between px-6 mb-4" style="min-height: 56px; margin-bottom: 20px;">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative" style="position: relative; width: 300px;">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" style="position: absolute; left: 12px; top: 50%; translate: 0 -50%; color: #94a3b8; font-size: 18px;">search</span>
                    <input class="search-glass w-full" 
                           placeholder="Buscar usuarios por nombre, cif o email..." 
                           type="text"
                           wire:model.debounce.300ms="searchUser"
                           style="width: 100%; border: none; background: rgba(255,255,255,0.6); border-radius: 12px; padding: 8px 10px 8px 36px; outline: none; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); font-size: 13px;">
                </div>
            </div>
        </header>

        <!-- Filters -->
        <div class="flex justify-between items-center mb-6 px-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding: 0 8px;">
            <div class="flex gap-2 flex-wrap" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <button class="px-4 py-1.5 glass-card rounded-full text-xs font-semibold {{ $activeUserFilter == 'all' ? 'text-primary border-primary/30' : 'text-slate-600' }}" 
                        style="padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer; border: 1px solid {{ $activeUserFilter == 'all' ? 'rgba(19, 91, 236, 0.2)' : 'transparent' }}; background: {{ $activeUserFilter == 'all' ? 'rgba(19, 91, 236, 0.05)' : 'rgba(255,255,255,0.4)' }}; color: {{ $activeUserFilter == 'all' ? '#135bec' : '#475569' }};"
                        wire:click="$set('activeUserFilter', 'all')">
                    Todos ({{ method_exists($usersList, 'total') ? $usersList->total() : count($usersList) }})
                </button>
                @foreach($departamentosList as $dept)
                    <button class="px-4 py-1.5 glass-card rounded-full text-xs font-semibold {{ $activeUserFilter == $dept->nombre ? 'text-primary border-primary/30' : 'text-slate-600' }}" 
                            style="padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer; border: 1px solid {{ $activeUserFilter == $dept->nombre ? 'rgba(19, 91, 236, 0.2)' : 'transparent' }}; background: {{ $activeUserFilter == $dept->nombre ? 'rgba(19, 91, 236, 0.05)' : 'rgba(255,255,255,0.4)' }}; color: {{ $activeUserFilter == $dept->nombre ? '#135bec' : '#475569' }};"
                            wire:click="$set('activeUserFilter', '{{ addslashes($dept->nombre) }}')">
                        {{ $dept->nombre }}
                    </button>
                @endforeach
            </div>
            
            <div class="d-flex align-items-center gap-2">
                 <span class="text-slate-500 font-medium text-xs" style="font-size: 12px; color: #64748b;">Mostrar:</span>
                 <select wire:model="userPerPage" class="form-select form-select-sm glass-card border-0 font-semibold" style="border-radius: 8px; width: 80px; padding: 4px 24px 4px 12px; cursor: pointer; font-size: 12px; color: #475569; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.02); background-color: rgba(255,255,255,0.6);">
                     <option value="10">10</option>
                     <option value="20">20</option>
                     <option value="50">50</option>
                     <option value="100">100</option>
                     <option value="all">Todos</option>
                 </select>
            </div>
        </div>

        @if($userViewMode === 'grid')
            <!-- Grid -->
            <div class="contact-grid">
                @forelse($usersList as $user)
                    <div class="glass-card contact-card p-4 {{ $selectedUserId == $user->id ? 'active' : '' }}" 
                         wire:click="selectUser({{ $user->id }})"
                         style="padding: 24px; cursor: pointer; display: flex; flex-direction: column;">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3" style="width: 100%;">
                            <div class="relative">
                                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nombre).'&background=random' }}" 
                                     class="contact-avatar" 
                                     alt="{{ $user->nombre }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                <div class="status-indicator {{ $loop->index % 3 == 0 ? 'status-online' : 'status-offline' }}"></div>
                            </div>
                            
                            <div class="d-flex flex-wrap justify-content-end gap-1" style="max-width: 160px;">
                                <button class="btn btn-sm rounded-circle btn-outline-success" title="Comunicación entrante" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: none; background: rgba(25, 135, 84, 0.1);">
                                    <i class="bi bi-box-arrow-in-right" style="font-size: 13px;"></i>
                                </button>
                                <button class="btn btn-sm rounded-circle btn-outline-info" title="Comunicación saliente" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: none; background: rgba(13, 202, 240, 0.1);">
                                    <i class="bi bi-box-arrow-up-right" style="font-size: 13px;"></i>
                                </button>
                                <button class="btn btn-sm rounded-circle" title="Crear tarea" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: none; background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                    <i class="bi bi-list-task" style="font-size: 13px;"></i>
                                </button>
                                <button class="btn btn-sm rounded-circle btn-outline-primary" title="Editar" wire:click.stop="openUserModal({{ $user->id }})" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: none; background: rgba(13, 110, 253, 0.1);">
                                    <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                </button>
                                <button class="btn btn-sm rounded-circle btn-outline-danger" title="Borrar" wire:click.stop="confirmDeleteUser({{ $user->id }})" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: none; background: rgba(220, 53, 69, 0.1);">
                                    <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-start" style="width: 100%;">
                            <h3 class="font-bold text-slate-900 mb-1" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">{{ $user->nombre }}</h3>
                            <p class="text-sm text-slate-500 font-medium" style="font-size: 12px; color: #64748b; margin-bottom: 2px;">{{ $user->departamento_nombre ?? 'Sin Departamento' }}</p>
                            <p class="text-primary font-semibold m-0 mt-1" style="font-size: 11px; color: #135bec; line-height: 1.2;">{{ $user->puesto ?? 'Sin Puesto' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-slate-400">
                        <span class="material-symbols-outlined text-5xl mb-4">search_off</span>
                        <p>No se han encontrado usuarios...</p>
                    </div>
                @endforelse

                <!-- Add New Placeholder -->
                <div class="glass-card flex flex-col items-center justify-center p-6 border-dashed border-2 border-slate-300 hover:bg-white/30 transition-all cursor-pointer group"
                     wire:click="openUserModal"
                     style="border-style: dashed; border-width: 2px; border-color: #cbd5e1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-100 text-slate-400 mb-2" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #94a3b8;">
                        <span class="material-symbols-outlined" style="font-size: 24px;">add</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400" style="font-size: 11px; font-weight: 700; color: #94a3b8;">Nuevo Usuario</p>
                </div>
            </div>
        @else
            <!-- VISTA DE LISTA (TABLA) -->
            <div class="widget-card p-0 shadow-sm border-0" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(10px); border-radius: 16px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="background: transparent;">
                        <thead style="background: rgba(255,255,255,0.5);">
                            <tr>
                                <th class="ps-4 py-2 text-dark small text-uppercase fw-bolder border-0">Usuario</th>
                                <th class="py-2 text-dark small text-uppercase fw-bolder border-0">Departamento</th>
                                <th class="py-2 text-dark small text-uppercase fw-bolder border-0">Puesto</th>
                                <th class="py-2 text-dark small text-uppercase fw-bolder border-0">Email</th>
                                <th class="py-2 text-dark small text-uppercase fw-bolder border-0">Teléfono</th>
                                <th class="pe-4 py-2 text-dark small text-uppercase fw-bolder text-end border-0">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($usersList as $user)
                                <tr style="cursor: pointer; {{ $selectedUserId == $user->id ? 'background: rgba(19, 91, 236, 0.05);' : '' }}" 
                                    wire:click="selectUser({{ $user->id }})">
                                    <td class="ps-4 py-2 border-light">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nombre).'&background=random' }}" 
                                                 class="rounded-circle shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->nombre }}</div>
                                                <div class="small text-muted" style="font-size: 0.75rem;">{{ $user->cif ?? 'SIN CIF' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 border-light">
                                        <span class="badge rounded-pill bg-light text-dark shadow-sm px-3" style="border: 1px solid rgba(0,0,0,0.1);">
                                            {{ $user->departamento_nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-2 border-light text-primary fw-semibold" style="font-size: 0.85rem;">
                                        {{ $user->puesto ?? '-' }}
                                    </td>
                                    <td class="py-2 border-light text-muted small">
                                        @php
                                            $allEls = array_unique(array_filter(array_merge([$user->email], explode('<br>', $user->emails_list ?? ''))));
                                        @endphp
                                        @forelse($allEls as $e)
                                            <div style="line-height:1.2; margin-bottom:2px;">{{ trim($e) }}</div>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td class="py-2 border-light text-muted small">
                                        @php
                                            $allPhs = array_unique(array_filter(explode('<br>', $user->tlf_ppal ?? '')));
                                        @endphp
                                        @forelse($allPhs as $p)
                                            <div style="line-height:1.2; margin-bottom:2px;">{{ trim($p) }}</div>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td class="pe-4 py-2 border-light text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button class="btn btn-sm rounded-circle btn-outline-success" title="Comunicación entrante" style="width: 32px; height: 32px; padding: 0; border: none; background: rgba(25, 135, 84, 0.1);">
                                                <i class="bi bi-box-arrow-in-right"></i>
                                            </button>
                                            <button class="btn btn-sm rounded-circle btn-outline-info" title="Comunicación saliente" style="width: 32px; height: 32px; padding: 0; border: none; background: rgba(13, 202, 240, 0.1);">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </button>
                                            <button class="btn btn-sm rounded-circle" title="Crear tarea" style="width: 32px; height: 32px; padding: 0; border: none; background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                                <i class="bi bi-list-task"></i>
                                            </button>
                                            <button class="btn btn-sm rounded-circle btn-outline-primary" title="Editar" wire:click.stop="openUserModal({{ $user->id }})" style="width: 32px; height: 32px; padding: 0; border: none; background: rgba(13, 110, 253, 0.1);">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-sm rounded-circle btn-outline-danger" title="Borrar" wire:click.stop="confirmDeleteUser({{ $user->id }})" style="width: 32px; height: 32px; padding: 0; border: none; background: rgba(220, 53, 69, 0.1);">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-5 text-center text-muted border-0">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-search fs-2 mb-3 opacity-50"></i>
                                            No se han encontrado usuarios...
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        @if($userPerPage !== 'all' && method_exists($usersList, 'links'))
            <div class="mt-4">
                {{ $usersList->links() }}
            </div>
        @endif
    </div>

    <!-- Detail Panel -->
    @if($userToView)
        <aside class="glass-card contact-detail-panel animate-slide-in">
            <!-- Panel Header -->
            <div class="p-8 flex items-start border-b border-white/40 gap-6" style="padding: 32px; display: flex; align-items: flex-start; gap: 24px; border-bottom: 1px solid rgba(255,255,255,0.4); position: relative;">
                <button class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors" 
                        wire:click="closeUserDetail"
                        style="position: absolute; top: 16px; right: 16px; border: none; background: transparent; color: #94a3b8; cursor: pointer;">
                    <span class="material-symbols-outlined">close</span>
                </button>
                
                <div class="rounded-3xl bg-cover bg-center border-4 border-white shadow-xl flex-shrink-0" 
                     style="width: 100px; height: 100px; border-radius: 20px; border: 4px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); background-image: url('{{ $userToView->avatar ? asset('storage/'.$userToView->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($userToView->nombre).'&size=200&background=random' }}')">
                </div>
                
                <div class="text-start flex-1" style="display: flex; flex-direction: column; justify-content: center; height: auto;">
                    <h2 class="text-slate-900 leading-tight mb-1" style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; line-height: 1.1;">{{ $userToView->nombre }}</h2>
                    <p class="text-slate-700 font-semibold mb-1" style="font-size: 15px; font-weight: 600; color: #334155; margin-bottom: 4px; line-height: 1.2;">{{ trim($userToView->p_nombre . ' ' . $userToView->apellidos) ?: 'Sin información personal' }}</p>
                    <p class="text-primary font-semibold mb-1 uppercase tracking-wider" style="color: #135bec; font-size: 11px; font-weight: 700; margin-bottom: 4px; letter-spacing: 0.1em; line-height: 1.2;">{{ $userToView->departamento_nombre ?? 'SIN DEPARTAMENTO' }}</p>
                    <p class="text-slate-500 font-semibold tracking-wider" style="color: #64748b; font-size: 12px; margin-bottom: 0; line-height: 1.2;">{{ $userToView->puesto ?? 'SIN PUESTO' }}</p>
                </div>
            </div>

            <!-- Panel Content -->
            <div class="flex-1 overflow-y-auto p-8" style="flex: 1; overflow-y: auto; padding: 32px;">
                <!-- Info Section -->
                <div class="mb-8" style="margin-bottom: 32px;">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4" style="font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 0.1em; margin-bottom: 16px;">Toda la Información</h4>
                    <div class="space-y-4" style="display: flex; flex-direction: column; gap: 16px;">
                        
                        <!-- Domicilio -->
                        @if($userToView->domicilio || $userToView->poblacion_nombre || $userToView->cpostal)
                        <div class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                            <div class="w-10 h-10 rounded-lg bg-white/50 flex items-center justify-center text-primary mt-1" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #135bec; flex-shrink: 0;">
                                <span class="material-symbols-outlined text-xl">location_on</span>
                            </div>
                            <div style="flex: 1;">
                                <p class="text-slate-400 font-bold uppercase mb-1" style="font-size: 9px; color: #94a3b8;">Dirección FÍsica</p>
                                <p class="text-sm font-semibold text-slate-700 m-0" style="font-size: 14px; color: #334155; line-height: 1.3;">{{ $userToView->domicilio ?: 'S/N' }}</p>
                                <p class="text-xs text-slate-500 m-0" style="font-size: 12px; color: #64748b; line-height: 1.3;">{{ trim($userToView->cpostal . ' ' . $userToView->poblacion_nombre) }} {{ $userToView->provincia_nombre ? '('.$userToView->provincia_nombre.')' : '' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Identidad -->
                        <div class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                            <div class="w-10 h-10 rounded-lg bg-white/50 flex items-center justify-center text-primary" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #135bec; flex-shrink: 0;">
                                <span class="material-symbols-outlined text-xl">badge</span>
                            </div>
                            <div style="flex: 1; align-self: center;">
                                <p class="text-slate-400 font-bold uppercase mb-1" style="font-size: 9px; color: #94a3b8;">Doc. Identidad</p>
                                <p class="text-sm font-semibold text-slate-700 m-0" style="font-size: 14px; color: #334155;">{{ $userToView->cif ?: 'No disponible' }}</p>
                            </div>
                        </div>

                        <!-- Emails -->
                        <div class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                            <div class="w-10 h-10 rounded-lg bg-white/50 flex items-center justify-center text-primary mt-1" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #135bec; flex-shrink: 0;">
                                <span class="material-symbols-outlined text-xl">mail</span>
                            </div>
                            <div style="flex: 1;">
                                <p class="text-slate-400 font-bold uppercase mb-1" style="font-size: 9px; color: #94a3b8;">Emails Asociados</p>
                                <div class="d-flex flex-column gap-1">
                                    @php
                                        $viewEmails = array_unique(array_filter(array_merge([$userToView->email], explode('<br>', $userToView->emails_list ?? ''))));
                                    @endphp
                                    @forelse($viewEmails as $ind => $e)
                                        <a href="#" wire:click.prevent="openMailboxWith('{{ trim($e) }}')" title="Enviar email" class="text-sm fw-semibold text-decoration-none" style="font-size: 14px; color: #135bec; display: inline-flex; align-items: center; gap: 6px; padding: 4px 8px; background: rgba(19, 91, 236, 0.05); border-radius: 6px; width: fit-content;">
                                            {{ trim($e) }} {!! $ind===0 ? '<span class="badge bg-primary rounded-pill flex-shrink-0" style="font-size: 9px; padding: 2px 6px;">Ppal</span>' : '' !!}
                                        </a>
                                    @empty
                                        <span class="text-sm text-slate-400">No disponible</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Teléfonos -->
                        <div class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                            <div class="w-10 h-10 rounded-lg bg-white/50 flex items-center justify-center text-primary mt-1" style="width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #135bec; flex-shrink: 0;">
                                <span class="material-symbols-outlined text-xl">phone</span>
                            </div>
                            <div style="flex: 1;">
                                <p class="text-slate-400 font-bold uppercase mb-1" style="font-size: 9px; color: #94a3b8;">Teléfonos Adicionales</p>
                                <div class="d-flex flex-column gap-1">
                                    @php
                                        $viewPhones = array_unique(array_filter(explode('<br>', $userToView->tlf_ppal ?? '')));
                                    @endphp
                                    @forelse($viewPhones as $p)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p) }}" title="Llamar" class="text-sm font-semibold text-decoration-none text-slate-700 hover:text-primary transition-colors hover:bg-slate-50" style="font-size: 14px; position: relative; display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(0,0,0,0.05); width: fit-content; gap: 6px;">
                                            <i class="bi bi-telephone-outbound text-muted" style="font-size: 11px;"></i> {{ trim($p) }}
                                        </a>
                                    @empty
                                        <span class="text-sm text-slate-400">No disponible</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6" style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 24px;">Interacciones recientes</h4>
                    <div class="timeline-container space-y-8" style="display: flex; flex-direction: column; gap: 32px;">
                        <!-- Static interactions for demo -->
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 mb-1" style="font-size: 9px; font-weight: 800; color: #94a3b8; margin-bottom: 4px;">ÚLTIMO ACCESO</span>
                                <h5 class="text-sm font-bold text-slate-800" style="font-size: 14px; font-weight: 800; color: #1e293b;">Login en sistema</h5>
                                <p class="text-xs text-slate-500 mt-1" style="font-size: 12px; color: #64748b;">Se conectó hoy a las 09:30 AM.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 bg-white/30 backdrop-blur-sm" style="padding: 24px; background: rgba(255,255,255,0.3); backdrop-filter: blur(4px);">
                <div class="flex justify-center gap-6 text-slate-400" style="display: flex; justify-content: center; gap: 24px; color: #94a3b8;">
                    <a class="hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined text-xl">language</span></a>
                    <a class="hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined text-xl">share</span></a>
                    <a class="hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined text-xl">description</span></a>
                </div>
            </div>
        </aside>
    @else
        <aside class="glass-card contact-detail-panel flex items-center justify-center p-10 text-center text-slate-400" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
             <span class="material-symbols-outlined text-6xl mb-4" style="font-size: 64px; margin-bottom: 16px; opacity: 0.4;">account_circle</span>
             <p class="font-bold">Selecciona un usuario para ver el detalle completo</p>
        </aside>
    @endif
</div>