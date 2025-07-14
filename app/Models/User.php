<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'profile_image', // add this
        'password',
        'phone', // <-- this line!
        'business_id', // <-- add here!
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'user_document');
    }

    //public function businesses()
    //{
    //    return $this->belongsToMany(Business::class); // or your existing business relation
    //}

    public function businessDocuments()
    {
        // Since user has one business, use 'business' relation, not 'businesses'
        if ($this->business) {
            return Document::whereHas('businesses', function ($query) {
                $query->where('id', $this->business->id);
            });
        }

        // Return empty query if no business assigned
        return Document::whereRaw('0=1');
    }
}
