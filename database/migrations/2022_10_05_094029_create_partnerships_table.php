<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('FieldMainkey')->nullable();
            $table->bigInteger('PartnerMainkey')->nullable();
            $table->string('PartnershipType',50)->nullable();
            $table->string('YearBegan',50)->nullable();
            $table->string('TempPartnerName',50)->nullable();
            $table->string('TempPartnerCity', 50)->nullable();
            $table->string('TempPartnerState', 50)->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->string('UpdateBy',255)->nullable();
            $table->integer('PartnershipID')->nullable();
            $table->string('FieldName',50)->nullable();
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
        Schema::dropIfExists('partnerships');
    }
}
