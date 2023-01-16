<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssignToTeacher extends Model
{
    use HasFactory;

    public $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
}
