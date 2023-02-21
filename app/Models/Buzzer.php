<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buzzer extends Model
{
    use HasFactory;

    public $guarded = [];

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function buzzerResult()
    {
        return $this->hasOne(BuzzerResult::class);
    }
}
