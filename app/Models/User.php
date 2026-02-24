<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * El nombre de la tabla en INTRANEXT159
     */
    protected $table = 'users';

    /**
     * Atributos asignables de tu tabla externa
     */
    protected $fillable = [
        'nombre',
        'email',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación: Mensajes que el usuario ha enviado
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relación: Mensajes que el usuario ha recibido como destinatario directo
     */
    public function receivedMessages()
    {
        return $this->hasMany(MessageRecipient::class, 'recipient_id');
    }

    /**
     * Relación: Mensajes de buzón compartido que están siendo atendidos por este usuario
     */
    public function assignedMessages()
    {
        return $this->hasMany(MessageRecipient::class, 'assigned_to');
    }
}
