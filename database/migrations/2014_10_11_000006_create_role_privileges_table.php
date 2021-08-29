
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_privileges', function (Blueprint $table) {
            $table->foreignId('privilege_id')->constrained()->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreignId('role_id')->constrained()->onUpdate('RESTRICT')->onDelete('RESTRICT');
        }); 
       
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('role_privileges');

}
}