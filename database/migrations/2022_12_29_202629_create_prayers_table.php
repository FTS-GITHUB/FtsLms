<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prayers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mosque_id');
            $table->string('fajar');
            $table->string('zuhar');
            $table->string('asar');
            $table->string('maghrib');
            $table->string('Isha');
            $table->string('al_juma');
            $table->foreign('mosque_id')->references('id')->on('mosques')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
