<?php

namespace App\Models;

// Pastikan bagian ini menggunakan Authenticatable, bukan Model biasa
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}