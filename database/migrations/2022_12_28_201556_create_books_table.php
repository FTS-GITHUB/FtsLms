<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->text('upload_book');
            $table->text('cover_image_caption');
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('book_price', 6, 2);
            $table->text('remarks')->nullable();
            $table->text('status');
            $table->timestamps();
        });
    }
};
