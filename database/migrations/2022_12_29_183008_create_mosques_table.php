<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->string('masjid_name');
            $table->string('address');
            $table->string('imame_name');
            $table->string('notice_board');
            $table->timestamps();
        });
    }
};
