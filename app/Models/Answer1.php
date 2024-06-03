<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer1 extends Model
{
    protected $table = 'answers1';
    protected $fillable = [
        'auditor_id',
        'image'
        // tambahkan kolom lain yang ingin Anda masukkan ke fillable di sini
    ];
public function questions()
{
    return $this->hasMany(Question::class);
}
public function auditor()
{
    return $this->belongsTo(User::class);
}
public function remarks()
{
    return $this->belongsToMany(Remark::class);
}
}
