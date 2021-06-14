<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RegisterTeacher extends Model
{
    protected $fillable = ["slug", "dimulai", "berakhir", "mapel"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
