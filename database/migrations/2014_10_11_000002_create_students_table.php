<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function(Blueprint $table){
            $table->string('cne')->primary();
            $table->string('level');
            $table->foreign('level')->references('id')->on('levels')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('bac_type');
            $table->float('bac_mark');
        });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('students');

}
}