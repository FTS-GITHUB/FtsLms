<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function courseAssignToTeachers()
    {
        return $this->hasMany(CourseAssignToTeacher::class);
    }
}
