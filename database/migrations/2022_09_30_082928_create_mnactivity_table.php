<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMnactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mnactivity', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('IndividualMainkey')->nullable();
            $table->bigInteger('EntityMainKey')->nullable();
            $table->datetime('ActBeginDate')->nullable();
            $table->datetime('ActEndDate')->nullable();
            $table->string('ContractType',50)->nullable();
            $table->string('TermLength', 50)->nullable();
            $table->string('Division', 50)->nullable();
            $table->string('HomeField', 50)->nullable();
            $table->datetime('Status')->nullable();
            $table->string('ActType',50)->nullable();
            $table->string('ActMin',50)->nullable();
            $table->string('ActSubMin1',50)->nullable();
            $table->string('ActSubMin2',50)->nullable();
            $table->string('ActSubMin3',50)->nullable();
            $table->string('ActSubMin4',50)->nullable();
            $table->string('ActLic',50)->nullable();
            $table->bigInteger('ActLicByMainkey')->nullable();
            $table->datetime('ActLicDate')->nullable();
            $table->string('Supervisor',50)->nullable();
            $table->string('ActComment',4000)->nullable();
            $table->bigInteger('ActMinuteID')->nullable();
            $table->datetime('EnteredDate')->nullable();
            $table->datetime('NODivision')->nullable();
            $table->string('NOOffice',50)->nullable();
            $table->string('Title',54)->nullable();
            $table->string('SeniorPastorOverride',1)->nullable();
            $table->string('ServiceOverride',1)->nullable();
            $table->string('PrintLicenseOverride',50)->nullable();
            $table->char('TourEligible',1)->nullable();
            $table->char('TourLocked',1)->nullable();
            $table->bigInteger('TourLength')->nullable();
            $table->decimal('EnvisionMonthlyCost',16,2)->nullable();
            $table->decimal('EnvisionInsuranceCost',16,2)->nullable();
            $table->decimal('EnvisionTravelCost',16,2)->nullable();
            $table->decimal('EnvisionMiscCost',16,2)->nullable();
            $table->decimal('EnvisionCostAdjustment',16,2)->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->string('UpdateBy',255)->nullable();
            $table->string('StatusReasonPrimary',255)->nullable();
            $table->string('StatusReasonSecondary',255)->nullable();
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
        Schema::dropIfExists('mnactivity');
    }
}
