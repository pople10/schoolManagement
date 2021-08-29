<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('user_id')->primary()->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('actionType');
            $table->string('Table');
            $table->binary('new_data');
            $table->binary('old_data')->nullable();
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
        Schema::dropIfExists('histories');
    }
}
