<?php

namespace App\Models;

use App\Models\{Absent, Student};
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    public function absents()
    {
        return $this->belongsToMany(Absent::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
