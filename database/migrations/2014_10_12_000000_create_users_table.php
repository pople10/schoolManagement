<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('vkey')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->bigInteger('role_id')->unique()->nullable();
            $table->string('matricule')->nullable();
            $table->string('phd')->unique()->nullable();
            $table->string('cne')->unique()->nullable();
            $table->string('cin')->unique()->nullable();
            $table->string('adress')->nullable();
            $table->string('telephone')->nullable();
            $table->string('sexe')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
