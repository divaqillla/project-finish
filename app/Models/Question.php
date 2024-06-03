<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    public function answers()
    {
        return $this->hasMany(FixAnswer::class);
    }

    public function supp_answers()
    {
        return $this->hasMany(SuppAnswer::class);
    }
    public function subsection()
    {
        return $this->belongsTo(Subsection::class, 'subsection_id');
    }
}
