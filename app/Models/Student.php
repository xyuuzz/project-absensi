<?php

namespace App\Models;

use App\Models\{User, Absent, Classes};
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ["nis", "nisn", "hobi"];

    public function absents()
    {
        return $this->belongsToMany(Absent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
