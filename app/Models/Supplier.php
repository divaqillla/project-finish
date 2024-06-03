<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Supplier extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'suppliers';


    protected $fillable =
    [
        'username',
        'password'
    ];

    protected $hidden = ['password',  'remember_token'];


    public function supp_answers()
    {
        return $this->hasMany(SuppAnswer::class,'auditor_id');
    }
}
