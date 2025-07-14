<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'overview',
        'location',
        // ... any other fields
    ];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
