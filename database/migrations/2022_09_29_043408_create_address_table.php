<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Mainkey')->nullable();
            $table->string('AddressType',50)->nullable();
            $table->string('Address1',50)->nullable();
            $table->string('Address2',50)->nullable();
            $table->string('Address3',50)->nullable();
            $table->string('City',50)->nullable();
            $table->string('State',50)->nullable();
            $table->string('Zip',50)->nullable();
            $table->string('Country',50)->nullable();
            $table->string('Continent',50)->nullable();
            $table->datetime('BeginDate')->nullable();
            $table->datetime('EndDate')->nullable();
            $table->string('HomePhone',50)->nullable();
            $table->string('OfficePhone',50)->nullable();
            $table->string('CellPhone',50)->nullable();
            $table->string('InternetPhone',50)->nullable();
            $table->string('Fax',50)->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->string('UpdateBy',255)->nullable();
            $table->text('Note')->nullable();
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
        Schema::dropIfExists('address');
    }
}
