<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_course_grade', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('student_id');
            $table->bigInteger('course_id');
            $table->bigInteger('grade_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_grade');
    }
};
