<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'is_global',
    ];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_document');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_document');
    }
}
