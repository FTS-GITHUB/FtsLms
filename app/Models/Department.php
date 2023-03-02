<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function classAllocates()
    {
        return $this->hasMany(ClassAllocate::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
