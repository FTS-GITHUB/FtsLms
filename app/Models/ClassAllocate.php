<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAllocate extends Model
{
    use HasFactory;

    public $guarded = [];

    public function departments()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
}
