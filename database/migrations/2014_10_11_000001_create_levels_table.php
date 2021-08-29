<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function(Blueprint $table){
            $table->string('id')->primary();
            $table->string('faculty');
            $table->foreign('faculty')->references('code')->on('faculties')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('label');
            $table->string('cycle');
        });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('levels');

}
}