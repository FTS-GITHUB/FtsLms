<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class React extends Model
{
    use HasFactory;

    public $guarded = [];

    public function reactable()
    {
        return $this->morphTo();
    }
}
