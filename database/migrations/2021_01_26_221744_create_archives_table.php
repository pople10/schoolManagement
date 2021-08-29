<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->string('student');
            $table->foreign('student')->references('cne')->on('students')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('level');
            $table->foreign('level')->references('id')->on('levels')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('archives');
    }
}
