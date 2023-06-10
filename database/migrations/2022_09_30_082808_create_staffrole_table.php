<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffrole', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('StaffID')->nullable();
            $table->bigInteger('RoleTypeID')->nullable();
            $table->string('Status', 50)->nullable();
            $table->string('AuthToken', 50)->nullable();
            $table->datetime('AddedDate')->nullable();
            $table->datetime('xEffectiveDate')->nullable();
            $table->datetime('xEffectiveEndDate')->nullable();
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
        Schema::dropIfExists('staffrole');
    }
}
