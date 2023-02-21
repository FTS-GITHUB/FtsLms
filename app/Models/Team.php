<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $guarded = [];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function buzzer()
    {
        return $this->belongsTo(Buzzer::class);
    }
}
