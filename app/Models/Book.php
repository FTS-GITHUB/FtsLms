<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $fillable = [
        'title', 'author', 'publisher', 'category', 'upload_book', 'description', 'book_price', 'cover_image_caption', 'remarks', 'status',
    ];
}
