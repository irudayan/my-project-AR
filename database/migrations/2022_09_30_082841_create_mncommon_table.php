<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMncommonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mncommon', function (Blueprint $table) {
            $table->id();
            $table->char('Indiv',6)->nullable();
            $table->string('PayrollIndiv',15)->nullable();
            $table->char('ChurchCode',7)->nullable();
            $table->string('ChurchDonorCode',2)->nullable();
            $table->char('FieldCode',4)->nullable();
            $table->char('DistrictCode',2)->nullable();
            $table->string('EntityType',50)->nullable();
            $table->string('FinancialType',50)->nullable();
            $table->string('SubFiles',50)->nullable();
            $table->bigInteger('Security')->nullable();
            $table->char('SecurityOverridden',1)->nullable();
            $table->string('IsConfidential',50)->nullable();
            $table->char('IMWebDisplay',1)->nullable();
            $table->char('NCMWebDisplay',1)->nullable();
            $table->string('ChurchMasterName',50)->nullable();
            $table->string('ChurchThanksName',50)->nullable();
            $table->string('SchoolType',50)->nullable();
            $table->string('MailingName',50)->nullable();
            $table->char('MailingNameOverride',1)->nullable();
            $table->string('FormalMailingNameOLD',50)->nullable();
            $table->string('LicenseName',55)->nullable();
            $table->string('Title',50)->nullable();
            $table->string('FirstName',50)->nullable();
            $table->string('MiddleName',50)->nullable();
            $table->string('LastName',50)->nullable();
            $table->string('Suffix',50)->nullable();
            $table->string('AlphaSortName',80)->nullable();
            $table->string('HomePhone',40)->nullable();
            $table->string('OfficePhone',40)->nullable();
            $table->string('Fax',40)->nullable();
            $table->string('CellPhone',40)->nullable();
            $table->string('WebSite',255)->nullable();
            $table->string('USAEmail',255)->nullable();
            $table->string('ForeignEmail',255)->nullable();
            $table->string('LocationCity',50)->nullable();
            $table->string('LocationState',50)->nullable();
            $table->string('LocationZip',50)->nullable();
            $table->string('LocationCountry',50)->nullable();
            $table->string('MailingCity',50)->nullable();
            $table->string('MailingState',50)->nullable();
            $table->string('MailingZip',50)->nullable();
            $table->string('MailingCountry',50)->nullable();
            $table->string('Gender',20)->nullable();
            $table->string('MaritalStatus',50)->nullable();
            $table->string('NameUsed',50)->nullable();
            $table->dateTime('DeceasedDate')->nullable();
            $table->dateTime('RetiredDate')->nullable();
            $table->string('DeceasedCity',50)->nullable();
            $table->string('DeceasedState',50)->nullable();
            // $table->string('NotifiedBy',255)->nullable();  
            $table->dateTime('ReportedDate')->nullable();
            $table->string('CommonNoMail',50)->nullable();
            $table->string('CommonNoEmail',50)->nullable();
            $table->string('CAMANoMail',50)->nullable();
            $table->string('OrchardNoMail',50)->nullable();
            $table->string('OrchardNoEmail',50)->nullable();
            $table->string('PrisonerNumber',50)->nullable();
            // $table->string('Denom',50)->nullable();
            $table->string('SourceOfLead',50)->nullable();
            $table->dateTime('AddDate')->nullable();
            $table->dateTime('UpdateDate')->nullable();
            $table->bigInteger('UpdateBy')->nullable(); 
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
        Schema::dropIfExists('mncommon');
    }
}
