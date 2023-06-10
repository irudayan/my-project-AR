<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEthnicityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ethnicity', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('autoinc')->nullable();
            $table->bigInteger('Mainkey')->nullable();
            $table->bigInteger('Qualifier')->nullable();
            $table->string('Ethnicity',255)->nullable();
            $table->bigInteger('Percentage')->nullable();
            $table->bigInteger('UpdateBy')->nullable();
            $table->datetime('UpdateDate')->nullable();
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
        Schema::dropIfExists('ethnicity');
    }
}
