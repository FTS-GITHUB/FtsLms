<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $fillable = [
        'masjid_name', 'address', 'imame_name', 'notice_board',
    ];

    public function prayers()
    {
        return $this->hasMany(Mosque::class);
    }
}
