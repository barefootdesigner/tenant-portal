<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'business_id',
        'is_global',
        'reply_to_id',
        'type',
        'subject',
        'message',
        'status',
        'created_by',
            'replies_allowed',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function readers()
{
    return $this->belongsToMany(\App\Models\User::class, 'message_user_reads')
        ->withPivot('read_at')
        ->withTimestamps();
}


    public function replies()
{
    return $this->hasMany(Message::class, 'reply_to_id')->orderBy('created_at');
}

public function parent()
{
    return $this->belongsTo(Message::class, 'reply_to_id');
}

}
