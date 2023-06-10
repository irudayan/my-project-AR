<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Mainkey')->nullable();
            $table->string('Email', 255)->nullable();
            $table->datetime('AddedDate')->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->string('UpdateBy')->nullable();
            $table->char('MNCommonUSARollover',1)->nullable();
            $table->char('MNCommonForeignRollover',1)->nullable();
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
        Schema::dropIfExists('email');
    }
}
