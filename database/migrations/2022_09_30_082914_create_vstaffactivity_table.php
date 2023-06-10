<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVstaffactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vstaffactivity', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('IndividualMainkey')->nullable();
            $table->bigInteger('EntityMainKey')->nullable();
            $table->dateTime('ActBeginDate')->nullable();
            $table->dateTime('ActEndDate')->nullable();
            $table->string('ContractType', 50)->nullable();
            $table->string('TermLength', 50)->nullable();
            $table->string('Division', 50)->nullable();
            $table->string('HomeField', 50)->nullable();
            $table->string('Status', 50)->nullable();
            $table->string('ActType', 50)->nullable();
            $table->string('ActMin', 50)->nullable();
            $table->string('ActSubMin1', 50)->nullable();
            $table->string('ActSubMin2', 50)->nullable();
            $table->string('ActSubMin3', 50)->nullable();
            $table->string('ActSubMin4', 50)->nullable();
            $table->string('ActLic', 50)->nullable();
            $table->bigInteger('ActLicByMainkey')->nullable();
            $table->dateTime('ActLicDate')->nullable();
            $table->string('Supervisor', 50)->nullable();
            $table->string('ActComment', 4000)->nullable();
            $table->bigInteger('ActMinuteID')->nullable();
            $table->dateTime('EnteredDate')->nullable();
            $table->string('NODivision', 50)->nullable();
            $table->string('NOOffice', 50)->nullable();
            $table->string('Title', 54)->nullable();
            $table->string('SeniorPastorOverride', 1)->nullable();
            $table->string('ServiceOverride', 1)->nullable();
            $table->string('PrintLicenseOverride', 50)->nullable();
            $table->char('TourEligible',1)->nullable();
            $table->char('TourLocked', 1)->nullable();
            $table->bigInteger('TourLength')->nullable();
            $table->dateTime('UpdateDate')->nullable();
            $table->string('UpdateBy', 255)->nullable();
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
        Schema::dropIfExists('vstaffactivity');
    }
}
