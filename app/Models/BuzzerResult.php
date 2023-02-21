<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuzzerResult extends Model
{
    use HasFactory;

    public $guarded = [];

    public function buzzer()
    {
        return $this->hasOne(Buzzer::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
