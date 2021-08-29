<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            
            $table->id();
            $table->text('question');
            $table->text('answer')->nullbale();
            $table->boolean('answered');
            $table->string('prof');
            $table->foreign('prof')->references('id')->on('phds')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('student');
            $table->foreign('student')->references('cne')->on('students')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('questions');
    }
}
