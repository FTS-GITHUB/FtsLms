<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buzzers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('team_id');
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('rounds')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
