<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->dateTime('date_start');
            $table->string('end_offer');
            $table->string('level');
            $table->foreign('level')->references('id')->on('levels')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('object');
            $table->string('type');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('internships');
    }
}
