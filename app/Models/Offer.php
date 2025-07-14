<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'headline',
        'body',
        'image',
        'start_date',
        'end_date',
        'category',
        'published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'published' => 'boolean',
    ];
}
