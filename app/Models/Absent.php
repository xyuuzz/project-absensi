<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Teacher, Schedule, Student, Classes};

class Absent extends Model
{
    protected $fillable = ["teacher_id", "schedule_id"];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class);
    }
}
