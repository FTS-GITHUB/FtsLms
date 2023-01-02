<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    use HasFactory;

    public $guarded = [];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
