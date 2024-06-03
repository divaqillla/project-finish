<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppAnswer extends Model
{
    use HasFactory;
    protected $table = 'supp_answer';
    protected $fillable =
    [
        'auditor_id',
        'question_id',
        'line',
        'vendor',
        'mark',
        'notes',
        'image'
    ];

    public function questions()
    {
        return $this->belongsTo(Question::class,'question_id',);
    }

    public function auditors()
    {
        return $this->belongsTo(Supplier::class,'auditor_id');

    }
}
