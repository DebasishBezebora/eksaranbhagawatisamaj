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
        Schema::create('examination_pass_marks', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('Course_Name');
            $table->integer('In_Semester');
            $table->integer('End_Semester');
            $table->timestamps();
            $table->ipAddress('visitor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examination_pass_marks');
    }
};
