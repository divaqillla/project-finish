<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    protected $table = 'sections';

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }

    public function subsections()
    {
        return $this->hasMany(Subsection::class);
    }


}
