<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictChurchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_churches', function (Blueprint $table) {
            $table->id();
            $table->string('DistrictMainkey', 50)->nullable();
            $table->string('DistrictName', 250)->nullable();
            $table->string('ChurchMainkey', 50)->nullable();
            $table->string('ChurchName', 250)->nullable();
            $table->string('AnnualReport', 50)->nullable();
            $table->string('CHRStatus', 250)->nullable();
            $table->string('MailingCity', 250)->nullable();
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
        Schema::dropIfExists('district_churches');
    }
}
