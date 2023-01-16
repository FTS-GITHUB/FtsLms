<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quranic extends Model
{
    use HasFactory;

    public $guarded = [];

    public function tags()
    {
        return $this->morphOne(Tag::class, 'taggable');
    }
}
