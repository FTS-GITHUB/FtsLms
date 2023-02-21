<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buzzer_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buzzer_id');
            $table->unsignedBigInteger('question_id');
            $table->string('total_marks');
            $table->string('obtained_marks');
            $table->foreign('buzzer_id')->references('id')->on('buzzers')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
