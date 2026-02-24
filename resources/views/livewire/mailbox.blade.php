<div>
    <link rel="stylesheet" href="{{ asset('css/mailbox-glass.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <div class="glass-mailbox-container">
        <!-- Sidebar -->
        <div class="glass-sidebar">
            <div class="glass-logo"
                style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="glass-logo-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    eMails
                </div>
                <button wire:click="setFolder('compose')" class="btn-compose-green" title="Redactar nuevo mensaje"
                    style="background: #10b981; color: white; border: none; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);">
                    <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                </button>
            </div>

            <nav class="glass-nav">
                <a href="#" class="glass-nav-item {{ $currentFolder === 'inbox' ? 'active' : '' }}"
                    wire:click.prevent="setFolder('inbox')">
                    <i class="bi bi-inbox"></i> Bandeja de Entrada
                    <span class="glass-badge">12</span>
                </a>
                <a href="#" class="glass-nav-item {{ $currentFolder === 'sent' ? 'active' : '' }}"
                    wire:click.prevent="setFolder('sent')">
                    <i class="bi bi-send"></i> Enviados
                </a>
                <a href="#" class="glass-nav-item {{ $currentFolder === 'drafts' ? 'active' : '' }}"
                    wire:click.prevent="setFolder('drafts')">
                    <i class="bi bi-file-earmark-text"></i> Borradores
                </a>
                <a href="#" class="glass-nav-item {{ $currentFolder === 'trash' ? 'active' : '' }}"
                    wire:click.prevent="setFolder('trash')">
                    <i class="bi bi-trash"></i> Papelera
                </a>

                <div
                    style="margin-top: 24px; margin-bottom: 8px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; padding-left: 16px;">
                    Opciones</div>
                <a href="#" class="glass-nav-item" wire:click.prevent="$emit('switchPage', 'configuracion')">
                    <i class="bi bi-gear"></i> Configuración
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="glass-main">
            <!-- Header -->
            <div class="glass-header">
                <div class="glass-header-title">
                    @php
                        $folderTitles = [
                            'inbox' => 'Bandeja de Entrada',
                            'sent' => 'Mensajes Enviados',
                            'drafts' => 'Borradores',
                            'trash' => 'Papelera',
                            'read' => 'Lectura de Mensaje',
                            'compose' => 'Redactar Nuevo Mensaje'
                        ];
                    @endphp
                    {{ $folderTitles[$currentFolder] ?? ucfirst($currentFolder) }}
                </div>

                <div class="glass-search-container">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" class="glass-search-input" placeholder="Buscar correos, contactos..."
                        wire:model.debounce.300ms="searchQuery">
                </div>

                <div class="glass-header-actions">
                    <i class="bi bi-bell fs-5 cursor-pointer"></i>
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.pravatar.cc/150?u=' . Auth::id() }}"
                        class="rounded-circle" style="width: 32px; height: 32px; border: 2px solid white;">
                </div>
            </div>

            @if($currentFolder === 'inbox')
                <!-- Priority Feed (Avatars) -->
                <div class="glass-priority-feed">
                    @foreach($priorityFeed as $item)
                        <div class="glass-priority-item {{ $activePriorityId == $item['id'] ? 'active' : '' }}"
                            wire:click="$set('activePriorityId', {{ $item['id'] }})">
                            <div class="glass-priority-avatar-wrapper">
                                <img src="{{ $item['avatar'] }}" class="glass-priority-avatar">
                            </div>
                            <span class="glass-priority-name">{{ $item['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="glass-split-view">
                <!-- Message List -->
                <div class="glass-message-list">
                    @forelse($mailList as $msg)
                        <div class="glass-message-card {{ $selectedMessageId == $msg->id ? 'active' : '' }}"
                            wire:click="readMessage({{ $msg->id }})">
                            <div class="glass-message-header">
                                <span
                                    class="glass-message-sender">{{ $currentFolder === 'inbox' ? ($msg->message->sender->nombre ?? 'Sistema') : ($msg->recipient->nombre ?? 'Destinatario') }}</span>
                                <span class="glass-message-time">{{ $msg->message->created_at->format('H:i A') }}</span>
                            </div>
                            <div class="glass-message-subject">{{ $msg->message->subject }}</div>
                            <div class="glass-message-snippet">{{ \Illuminate\Support\Str::limit($msg->message->body, 80) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">No se han encontrado mensajes.</div>
                    @endforelse
                </div>

                <!-- Message Detail -->
                <div class="glass-message-detail">
                    @if($currentFolder === 'read' && $messageToRead)
                        <div class="glass-detail-header">
                            <div class="glass-sender-info">
                                <img src="{{ $messageToRead->message->sender->avatar ? asset('storage/' . $messageToRead->message->sender->avatar) : 'https://i.pravatar.cc/150?u=' . $messageToRead->message->sender_id }}"
                                    class="glass-sender-avatar">
                                <div>
                                    <div class="glass-sender-name">
                                        {{ $messageToRead->message->sender->nombre ?? 'Sistema' }}
                                    </div>
                                    <div class="glass-sender-email">Para: mí &lt;{{ Auth::user()->email }}&gt;</div>
                                </div>
                            </div>
                            <div class="d-flex gap-3 text-muted">
                                <i class="bi bi-star mt-1 fs-5 cursor-pointer"></i>
                                <i class="bi bi-three-dots-vertical mt-1 fs-5 cursor-pointer"></i>
                            </div>
                        </div>

                        <div class="glass-detail-subject">{{ $messageToRead->message->subject }}</div>
                        <div class="glass-tag">Sincronización Interna</div>

                        <div class="glass-detail-body">{{ $messageToRead->message->body }}</div>

                        <!-- Dummy Attachment -->
                        <div class="glass-attachment">
                            <div class="glass-attachment-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div class="glass-attachment-info">
                                <span class="glass-attachment-name">roadmap_draft_q3.fig</span>
                                <span class="glass-attachment-size">12.4 MB • Actualizado hace 2h</span>
                            </div>
                            <i class="bi bi-download ms-4 cursor-pointer"></i>
                        </div>

                        <div class="glass-detail-actions">
                            <button class="glass-action-btn primary">
                                <i class="bi bi-reply"></i> Responder
                            </button>
                            <button class="glass-action-btn primary">
                                <i class="bi bi-arrow-right"></i> Reenviar
                            </button>
                            <button class="glass-action-btn secondary">
                                <i class="bi bi-archive"></i> Archivar
                            </button>
                        </div>
                    @elseif($currentFolder === 'compose')
                        <div class="glass-compose-container">
                            <!-- Zen Header -->
                            <div class="zen-header flex justify-between items-center"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                                    <span class="material-symbols-outlined text-primary">edit_square</span>
                                    <h1 class="text-slate-800 font-bold text-lg" style="margin: 0; font-size: 18px;">Nuevo
                                        Mensaje</h1>
                                </div>
                                <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                    <button class="zen-tool-btn" wire:click="setFolder('inbox')">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
                                    </button>
                                </div>
                            </div>

                            <form wire:submit.prevent="sendMessage" class="flex flex-col h-full"
                                style="display: flex; flex-direction: column; flex: 1;">
                                <!-- Fields -->
                                <div class="flex flex-col">
                                    <div class="zen-field"
                                        style="background: rgba(255, 255, 255, 0.4); margin: 8px 32px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05);">
                                        <label class="zen-label" style="padding-left: 16px;">Para</label>
                                        <div class="flex-1 flex flex-wrap gap-2 items-center"
                                            style="display: flex; flex-wrap: wrap; gap: 8px; flex: 1; align-items: center; padding: 8px 0;">
                                            @if($composeRecipientId)
                                                @php
                                                    $selectedUser = $usersList->firstWhere('id', $composeRecipientId);
                                                @endphp
                                                @if($selectedUser)
                                                    <div class="zen-recipient-chip">
                                                        {{ $selectedUser->nombre }}
                                                        <button type="button"
                                                            style="border: none; background: transparent; color: inherit; cursor: pointer; display: flex;"
                                                            wire:click="$set('composeRecipientId', null)">
                                                            <span class="material-symbols-outlined"
                                                                style="font-size: 14px;">close</span>
                                                        </button>
                                                    </div>
                                                @endif
                                            @elseif($composeExternalEmail)
                                                <div class="zen-recipient-chip">
                                                    {{ $composeExternalEmail }}
                                                    <button type="button"
                                                        style="border: none; background: transparent; color: inherit; cursor: pointer; display: flex;"
                                                        wire:click="$set('composeExternalEmail', '')">
                                                        <span class="material-symbols-outlined"
                                                            style="font-size: 14px;">close</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <select class="zen-input" wire:model="composeRecipientId"
                                                style="max-width: 200px; padding: 4px 8px; background: rgba(255,255,255,0.5); border-radius: 8px; border: 1px solid rgba(0,0,0,0.05);">
                                                <option value="">Seleccionar...</option>
                                                @foreach($usersList as $user)
                                                    <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button"
                                            class="text-slate-400 hover:text-primary text-xs font-bold uppercase tracking-widest transition-colors"
                                            style="border: none; background: transparent; font-size: 10px; color: #94a3b8; cursor: pointer; padding-right: 16px;">CC
                                            / CCO</button>
                                    </div>

                                    <div class="zen-field"
                                        style="background: rgba(255, 255, 255, 0.4); margin: 8px 32px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05);">
                                        <label class="zen-label" style="padding-left: 16px;">Asunto</label>
                                        <input class="zen-input" placeholder="¿Sobre qué trata este mensaje?" type="text"
                                            wire:model.defer="composeSubject"
                                            style="padding: 12px 16px; background: rgba(255,255,255,0.5); border-radius: 8px; border: 1px solid rgba(0,0,0,0.05); margin-right: 16px;">
                                    </div>
                                    @error('composeSubject') <div class="px-8 py-1"><span
                                    class="text-danger small">{{ $message }}</span></div> @enderror
                                </div>

                                <!-- Body -->
                                <div class="zen-editor-wrapper" style="padding: 16px 32px; flex: 1; min-height: 0;">
                                    <textarea class="zen-text-area" placeholder="Empieza a escribir tus pensamientos..."
                                        wire:model.defer="composeBody"
                                        style="background: rgba(255,255,255,0.5); border: 1px solid rgba(0,0,0,0.1); width: 100%; height: 100%;"></textarea>
                                    @error('composeBody') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <!-- Footer -->
                                <div class="zen-footer">
                                    <div class="zen-toolbar">
                                        <button type="button" class="zen-tool-btn" title="Negrita"><span
                                                class="material-symbols-outlined">format_bold</span></button>
                                        <button type="button" class="zen-tool-btn" title="Cursiva"><span
                                                class="material-symbols-outlined">format_italic</span></button>
                                        <button type="button" class="zen-tool-btn" title="Lista"><span
                                                class="material-symbols-outlined">format_list_bulleted</span></button>
                                        <button type="button" class="zen-tool-btn" title="Enlace"><span
                                                class="material-symbols-outlined">link</span></button>
                                        <div style="width: 1px; height: 24px; background: rgba(0,0,0,0.1); margin: 0 4px;">
                                        </div>
                                        <button type="button" class="zen-tool-btn" title="Adjuntar"><span
                                                class="material-symbols-outlined">attach_file</span></button>
                                        <button type="button" class="zen-tool-btn" title="Emoji"><span
                                                class="material-symbols-outlined">sentiment_satisfied</span></button>
                                    </div>

                                    <div class="flex items-center gap-4"
                                        style="display: flex; gap: 16px; align-items: center;">
                                        <button type="button"
                                            class="text-slate-500 hover:text-red-500 transition-all font-medium"
                                            style="border: none; background: transparent; color: #64748b; cursor: pointer;"
                                            wire:click="setFolder('inbox')">
                                            Descartar
                                        </button>
                                        <button type="submit" class="zen-send-btn">
                                            <span>Enviar</span>
                                            <div class="zen-send-icon-box">
                                                <span class="material-symbols-outlined"
                                                    style="font-size: 20px; rotate: -45deg;">send</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                            <i class="bi bi-envelope fs-1 mb-3"></i>
                            <p>Selecciona un mensaje para leerlo</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>