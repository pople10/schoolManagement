<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->string('title');
            $table->string('type');
            $table->text('content');
            $table->unsignedBigInteger('role')->nullable();
            $table->foreign('role')->references('id')->on('roles')->constrained()->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->string('attachement')->nullable();
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
        Schema::dropIfExists('announcements');
    }
}
