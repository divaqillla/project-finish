<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function auditor()
    {
        return $this->belongsTo(User::class);
    }
}
