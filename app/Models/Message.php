<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'subject',
        'body',
    ];

    /**
     * Relationship: The user who sent the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship: All recipients of this message
     */
    public function recipients()
    {
        return $this->hasMany(MessageRecipient::class, 'message_id');
    }
}
