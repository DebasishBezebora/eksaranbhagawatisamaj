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
        Schema::create('exam_semesters', function (Blueprint $table) {
            $table->id('EID');
            $table->string('Exam_Name');
            $table->enum('Exam_Type', ['0', '1'])->nullable();
            $table->string('Exam_Category')->nullable();
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
        Schema::dropIfExists('exam_semesters');
    }
};
