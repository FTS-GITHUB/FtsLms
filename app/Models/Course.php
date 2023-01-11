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
        return $this->hasMany(Department::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassAllocate::class);
    }
}
