<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsection extends Model
{
    protected $table = 'subsections';

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
