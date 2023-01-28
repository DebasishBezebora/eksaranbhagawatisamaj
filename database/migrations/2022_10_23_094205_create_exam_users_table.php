<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_users', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('Mobile_Number');
            $table->string('Password');
            $table->enum('Status', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_users');
    }
};
