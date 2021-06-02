<?php

namespace App\Models;

use App\Models\{User, Classes};
use Illuminate\Database\Eloquent\Model;

class RegisterStudent extends Model
{
    protected $fillable = ["classes_id", "slug", "dimulai", "berakhir"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
