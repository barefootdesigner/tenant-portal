<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['question', 'options', 'status'];

    protected $casts = [
        'options' => 'array',
    ];

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }
}
