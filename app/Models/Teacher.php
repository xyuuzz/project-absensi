<?php

namespace App\Models;

use App\Models\{Absent, User};
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ["nign", "mapel"];
    protected $with = ["user"];

    public function absent()
    {
        return $this->hasMany(Absent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
