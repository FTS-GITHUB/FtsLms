<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('islamic_short_stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('islamic_short_stories');
            $table->timestamps();
        });
    }
};
