<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_report', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Mainkey')->nullable();
            $table->integer('YearReported')->nullable();
            $table->char('YearCompleteFlag',1)->nullable();
            $table->char('Submitted',1)->nullable();
            $table->datetime('SubmittedDate')->nullable();
            $table->char('Verified',1)->nullable();
            $table->integer('MembersRemoved')->nullable();
            $table->integer('MembersAdded')->nullable();
            $table->integer('MembersTotal')->nullable();
            $table->integer('PreviousYearMembers')->nullable();
            $table->integer('AdherentsTotal')->nullable();
            $table->integer('InclusiveTotal')->nullable();
            $table->integer('MorningAttendance')->nullable();
            $table->integer('SmallGroupAttendance')->nullable();
            $table->integer('YouthGroupAttendance')->nullable();
            $table->integer('ChildrenAttendance')->nullable();
            $table->integer('Conversions0to11')->nullable();
            $table->integer('Conversions12to18')->nullable();
            $table->integer('Conversions19to30')->nullable();
            $table->integer('ConversionsOver30')->nullable();
            $table->integer('ConversionsTotal')->nullable();
            $table->integer('BaptismsTotal')->nullable();
            $table->integer('IncomeLocal')->nullable();
            $table->integer('FamilySupportLocal')->nullable();
            $table->integer('FamilySupportGCM')->nullable();
            $table->integer('DistrictOperatingBudget')->nullable();
            $table->integer('DistrictChurchPlantBudget')->nullable();
            $table->integer('STMCMAForeign')->nullable();
            $table->integer('STMCMADomestic')->nullable();
            $table->integer('STMCMAContributions')->nullable();
            $table->integer('STMNonCMAForeign')->nullable();
            $table->integer('STMNonCMADomestic')->nullable();
            $table->integer('STMNonCMAContributions')->nullable();
            $table->string('STMEvent',50)->nullable();
            $table->integer('BulletinCount')->nullable();
            $table->string('Language',50)->nullable();
            $table->string('LanguageOther',50)->nullable();
            $table->integer('MultiSiteLocations')->nullable();
            $table->string('ChurchDebt',50)->nullable();
            $table->char('MembershipDone',1)->nullable();
            $table->char('AttendanceDone',1)->nullable();
            $table->char('ConversionsDone',1)->nullable();
            $table->char('BaptismsDone',1)->nullable();
            $table->char('IncomeDone',1)->nullable();
            $table->char('ContributionsDone',1)->nullable();
            $table->char('STMCMADone',1)->nullable();
            $table->char('STMNonCMADone',1)->nullable();
            $table->char('MiscellaneousDone',1)->nullable();
            $table->char('StaffDone',1)->nullable();
            $table->char('CommentDone',1)->nullable();
            $table->string('Comment',2500)->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->integer('UpdateBy')->nullable();
            $table->integer('LeadersDeveloped')->nullable();
            $table->integer('LeadersDeployed')->nullable();
            $table->string('PlantIntent',1)->nullable();
            $table->string('ChurchMultDone',1)->nullable();
            $table->integer('DigitalAttendance')->nullable();
            $table->string('Ethnicity',50)->nullable();
            $table->string('CAProgramConsultation',1)->nullable();
            $table->string('CAProgramPEAK',1)->nullable();
            $table->string('CAProgramATMN',1)->nullable();
            $table->string('CAProgramFreshStart',1)->nullable();
            $table->string('CAProgramMaxImpact',1)->nullable();
            $table->string('EthnicityOther',255)->nullable();
            $table->string('CAProgramDynamicInfluence')->nullable();
            $table->string('DiscipleshipPlan',1)->nullable();
            $table->integer('DiscipleshipPlanNumber')->nullable();
            $table->string('LeadershipPlan',1)->nullable();
            $table->integer('LeadershipPlanNumber')->nullable();
            $table->string('EvangelismPlan',1)->nullable();
            $table->integer('EvangelismPlanNumber')->nullable();
            $table->string('OutreachPlan',1)->nullable();
            $table->integer('OutreachPlanNumber')->nullable();
            $table->integer('GroupPrayer')->nullable();
            $table->integer('AllianceWorkersSupported')->nullable();
            $table->string('DigitalService',1)->nullable();
            $table->string('ChurchPlant',1)->nullable();
            $table->text('ChurchPlantList')->nullable();
            $table->string('UpdateByName',55)->nullable();
            $table->string('MailingName',55)->nullable();
            $table->string('AMGiving',11)->nullable();
            $table->string('GCFGiving',11)->nullable();
            $table->string('AMGivingPercent',11)->nullable();
            $table->string('GCFGivingPercent',11)->nullable();
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
        Schema::dropIfExists('annual_report');
    }
}
