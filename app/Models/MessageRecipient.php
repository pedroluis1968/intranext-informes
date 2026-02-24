<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'recipient_id',
        'recipient_role',
        'read_at',
        'deleted_by_sender',
        'deleted_by_recipient',
        'status',
        'assigned_to',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'deleted_by_sender' => 'boolean',
        'deleted_by_recipient' => 'boolean',
    ];

    /**
     * Relationship: The message this recipient info belongs to
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    /**
     * Relationship: The specific user recipient (if applicable)
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Relationship: The user who is assigned to handle this message (for shared inboxes)
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
