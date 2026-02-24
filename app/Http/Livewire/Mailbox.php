<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\MessageRecipient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Mailbox extends Component
{
    public $currentFolder = 'inbox'; // inbox, sent, compose, read
    public $mailList = [];
    public $selectedMessageId = null;
    public $messageToRead = null;

    // Compose form
    public $composeSubject = '';
    public $composeBody = '';
    public $composeRecipientId = null;
    public $composeRecipientRole = '';
    public $composeExternalEmail = '';
    public $usersList = [];
    public $draftEmail = null;

    // UI State
    public $searchQuery = '';
    public $priorityFeed = [];
    public $activePriorityId = null;

    protected $listeners = ['refreshMailbox' => '$refresh'];

    public function mount()
    {
        $this->loadMessages();
        // Cargar lista de usuarios para poder enviarles correos (simplificado)
        $this->usersList = User::where('id', '!=', Auth::id())->get(['id', 'nombre', 'email', 'avatar']);

        if ($this->draftEmail) {
            $this->currentFolder = 'compose';
            $user = $this->usersList->firstWhere('email', $this->draftEmail);
            if ($user) {
                $this->composeRecipientId = $user->id;
            } else {
                $this->composeExternalEmail = $this->draftEmail;
            }
        }

        // Dummy Priority Feed
        $this->priorityFeed = [
            ['id' => 1, 'name' => 'Sarah J.', 'avatar' => 'https://i.pravatar.cc/150?u=sarah'],
            ['id' => 2, 'name' => 'Mike Ross', 'avatar' => 'https://i.pravatar.cc/150?u=mike'],
            ['id' => 3, 'name' => 'Alex Chen', 'avatar' => 'https://i.pravatar.cc/150?u=alex'],
            ['id' => 4, 'name' => 'Emma V.', 'avatar' => 'https://i.pravatar.cc/150?u=emma'],
            ['id' => 5, 'name' => 'Jordan K.', 'avatar' => 'https://i.pravatar.cc/150?u=jordan'],
            ['id' => 6, 'name' => 'Clara Smith', 'avatar' => 'https://i.pravatar.cc/150?u=clara'],
        ];
    }

    public function loadMessages()
    {
        $user = Auth::user();

        if ($this->currentFolder === 'inbox') {
            // Bandeja de Entrada directos al usuario
            $this->mailList = MessageRecipient::with('message.sender')
                ->where('recipient_id', $user->id)
                ->where('deleted_by_recipient', false)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->currentFolder === 'sent') {
            // Bandeja de Salida (Los que el usuario ha enviado)
            $this->mailList = MessageRecipient::with(['message.sender', 'recipient'])
                ->whereHas('message', function ($q) use ($user) {
                    $q->where('sender_id', $user->id);
                })
                ->where('deleted_by_sender', false)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function setFolder($folder)
    {
        $this->currentFolder = $folder;
        $this->selectedMessageId = null;
        $this->messageToRead = null;

        if ($folder !== 'compose') {
            $this->loadMessages();
        } else {
            $this->resetComposeForm();
        }
    }

    public function readMessage($id)
    {
        $this->selectedMessageId = $id;
        $this->currentFolder = 'read';

        $recipientRecord = MessageRecipient::with(['message.sender', 'recipient'])->find($id);

        if ($recipientRecord) {
            $this->messageToRead = $recipientRecord;

            // Marcar como leído si está en la bandeja de entrada y no está leído
            if (is_null($recipientRecord->read_at) && $recipientRecord->recipient_id === Auth::id()) {
                $recipientRecord->update(['read_at' => now()]);
            }
        }
    }

    public function resetComposeForm()
    {
        $this->composeSubject = '';
        $this->composeBody = '';
        $this->composeRecipientId = null;
        $this->composeRecipientRole = '';
        $this->composeExternalEmail = '';
    }

    public function sendMessage()
    {
        $this->validate([
            'composeSubject' => 'required|string|max:255',
            'composeBody' => 'required|string',
            'composeRecipientId' => 'nullable|exists:users,id',
            'composeRecipientRole' => 'nullable|string',
            'composeExternalEmail' => 'nullable|email'
        ]);

        if (!$this->composeRecipientId && !$this->composeRecipientRole && !$this->composeExternalEmail) {
            $this->addError('composeRecipientId', 'Debe seleccionar un destinatario.');
            return;
        }

        try {
            DB::beginTransaction();

            $message = Message::create([
                'sender_id' => Auth::id(),
                'subject' => $this->composeSubject,
                'body' => $this->composeBody,
            ]);

            $role = $this->composeRecipientRole ?: ($this->composeExternalEmail ?: null);

            MessageRecipient::create([
                'message_id' => $message->id,
                'recipient_id' => $this->composeRecipientId ?: null,
                'recipient_role' => $role,
            ]);

            DB::commit();

            // Resolve email address
            $recipientEmail = null;
            if ($this->composeRecipientId) {
                $recipientUser = User::find($this->composeRecipientId);
                if ($recipientUser) {
                    $recipientEmail = $recipientUser->email;
                }
            } elseif ($this->composeExternalEmail) {
                $recipientEmail = $this->composeExternalEmail;
            }

            // Attempt to send physical email if we have an address
            if ($recipientEmail) {
                try {
                    // Enviar como html o texto basico
                    Mail::html($this->composeBody, function ($msg) use ($recipientEmail) {
                        $msg->to($recipientEmail)
                            ->subject($this->composeSubject);
                    });
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error("Mail exception: " . $mailEx->getMessage());
                    // Not failing the internal saving, but we could notify the user here if desired.
                }
            }

            $this->setFolder('sent');
            $this->emit('swal:alert', [
                'type' => 'success',
                'title' => 'Enviado',
                'text' => 'El mensaje ha sido enviado correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('swal:alert', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se ha podido enviar el mensaje: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.mailbox');
    }
}
