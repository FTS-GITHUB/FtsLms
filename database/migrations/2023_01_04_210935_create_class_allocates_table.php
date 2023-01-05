<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_allocates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('course_id');
            $table->string('room');
            $table->string('days');
            $table->string('from');
            $table->string('to');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->timestamps();
        });
    }
};
