<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpastorrolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpastorroles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Mainkey')->nullable();
            $table->bigInteger('EntityMainkey')->nullable();
            $table->string('EntityName', 50)->nullable();
            $table->string('EntityType', 50)->nullable();
            $table->Integer('RoleTypeID')->nullable();
            $table->string('RoleName', 50)->nullable();
            $table->string('RoleDescription', 4000)->nullable();
            $table->string('RoleApp', 50)->nullable();
            $table->datetime('AddedDate')->nullable();
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
        Schema::dropIfExists('vpastorroles');
    }
}
