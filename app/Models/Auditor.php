<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Auditor extends Authenticatable
{
    protected $table = 'auditors';
    protected $fillable = ['name', 'role', 'nrp', 'email', 'password'];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function answers()
    {
        return $this->hasMany(FixAnswer::class);
    }

    public function supp_answers()
    {
        return $this->hasMany(SuppAnswer::class);
    }
}
