<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $guarded = [];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
