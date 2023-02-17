<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $guarded = [];

    public function departments()
    {
        return $this->belongsTo(Department::class);
    }

    public function classAlocates()
    {
        return $this->hasMany(ClassAllocate::class);
    }

    public function courseAssignToTeacher()
    {
        return $this->hasMany(CourseAssignToTeacher::class);
    }
}
