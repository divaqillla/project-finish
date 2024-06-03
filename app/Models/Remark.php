<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = [
        'answer_id',
        'question_id',
        'remark',
        'note'
    ];
    public function answer()
{
    return $this->belongsToMany(Answer1::class);
}
}
