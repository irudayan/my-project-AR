<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChurchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('church', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Mainkey')->nullable();
            $table->string('CHRStatus', 50)->nullable();
            $table->string('CHRMailTo', 50)->nullable();
            $table->string('CHRNoMail', 50)->nullable();
            $table->string('CHRNoEmail', 50)->nullable();
            $table->dateTime('AccreditedDate')->nullable();
            $table->dateTime('AffiliatedDate')->nullable();
            $table->dateTime('CeasedAffiliationDate')->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('CloseDate')->nullable();
            $table->string('Campaign', 50)->nullable();
            $table->string('County', 50)->nullable();
            $table->string('ChurchEthnic', 50)->nullable();
            $table->string('DirectoryCity', 50)->nullable();
            $table->string('ClosureReason', 100)->nullable();
            $table->string('SecondaryClosureReason', 100)->nullable();
            $table->string('ThirdClosureReason', 100)->nullable();
            $table->char('Replanted', 1)->nullable();
            $table->string('ResidualAssetsUse', 4000)->nullable();
            $table->string('InsightsGained', 4000)->nullable();
            $table->string('PotentialPlantCode', 8)->nullable();
            $table->string('PotentialChurchName', 100)->nullable();
            $table->char('AnnualReport', 1)->nullable();
            $table->char('IMKPIReport', 2)->nullable();
            $table->string('ChurchType', 50)->nullable();
            $table->dateTime('ProjectedLaunchDate')->nullable();
            $table->char('ChurchPlantDistrictCode', 2)->nullable();
            $table->string('MotherChurch', 100)->nullable();
            $table->string('DaughterChurch', 100)->nullable();
            $table->string('AssetsValue', 50)->nullable();
            $table->dateTime('UpdateDate')->nullable();
            $table->string('UpdateBy', 50)->nullable();
            $table->dateTime('GreenhouseStartDate')->nullable();
            $table->dateTime('GreenhouseEndDate')->nullable();
            $table->dateTime('ATMNNeedDate')->nullable();
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
        Schema::dropIfExists('church');
    }
}
