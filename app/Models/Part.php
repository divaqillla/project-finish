<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
        // protected $table = 'parts';
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
