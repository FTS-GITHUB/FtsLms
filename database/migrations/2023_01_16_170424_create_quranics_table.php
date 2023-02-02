<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quranics', function (Blueprint $table) {
            $table->id();
            $table->string('qari_name');
            $table->string('surah_name');
            $table->string('para_number');

            $table->timestamps();
        });
    }
};
