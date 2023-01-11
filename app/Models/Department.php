<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $guarded = [];

    public function classAllocates()
    {
        return $this->hasMany(ClassAllocate::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
