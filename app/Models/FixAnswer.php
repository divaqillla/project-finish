<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixAnswer extends Model
{
    use HasFactory;

    protected $table = 'fix_answers';
    protected $fillable =
    [
        'auditor_id',
        'question_id',
        'mark',
        'notes',
        'image',
        'created_at'
    ];

    public function questions()
    {
        return $this->belongsTo(Question::class,'question_id');
    }

    public function auditors()
    {
        return $this->belongsTo(User::class,'auditor_id','id');

    }


}
