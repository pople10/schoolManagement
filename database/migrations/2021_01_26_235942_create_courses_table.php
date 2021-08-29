<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('description');
            $table->dateTime('date_created');
            $table->unsignedBigInteger('prof');
            $table->foreign('prof')->references('id')->on('users')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('module');
            $table->foreign('module')->references('code')->on('modules')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('pdf_path');
            $table->string('video')->nullable();
            $table->string('school_year');
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
        Schema::dropIfExists('courses');
    }
}
