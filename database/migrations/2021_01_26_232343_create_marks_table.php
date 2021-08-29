<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->string('student');
            $table->foreign('student')->references('cne')->on('students')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->unsignedBigInteger('module_level');
            $table->foreign('module_level')->references('id')->on('module_levels')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->float('mark');
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
        Schema::dropIfExists('marks');
    }
}
