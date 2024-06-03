<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppAnswer1 extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'auditor_id',
        'question_id',
        // 'line',
        // 'vendor',
        'mark',
        'notes',
        'image'
    ];
}
