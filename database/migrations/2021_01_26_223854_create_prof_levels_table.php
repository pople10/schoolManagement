<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_modules', function (Blueprint $table) {
            $table->string('prof');
            $table->foreign('prof')->references('id')->on('phds')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('module');
            $table->foreign('module')->references('code')->on('modules')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('prof_levels');
    }
}
