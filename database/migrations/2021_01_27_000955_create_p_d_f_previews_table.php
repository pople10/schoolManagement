<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePDFPreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_d_f_previews', function (Blueprint $table) {
            $table->string('student');
            $table->foreign('student')->references('cne')->on('students')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('course');
            $table->foreign('course')->references('id')->on('courses')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('p_d_f_previews');
    }
}
