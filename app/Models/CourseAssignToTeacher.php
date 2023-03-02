<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssignToTeacher extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
