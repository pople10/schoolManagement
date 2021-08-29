<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_levels', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreign('code')->references('code')->on('modules')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('level');
            $table->foreign('level')->references('id')->on('levels')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('module_levels');
    }
}
