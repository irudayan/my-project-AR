<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('StaffMainkey')->nullable();
            $table->bigInteger('EntityMainkey')->nullable();
            $table->string('Title', 50)->nullable();
            $table->string('FirstName', 50)->nullable();
            $table->string('MiddleName', 50)->nullable();
            $table->string('LastName', 50)->nullable();
            $table->string('Suffix', 50)->nullable();
            $table->string('Gender', 50)->nullable();
            $table->string('Email', 50)->nullable();
            $table->string('Phone', 50)->nullable();
            $table->string('PositionTitle', 100)->nullable();
            $table->string('Comment', 4000)->nullable();
            $table->string('NOComment', 4000)->nullable();
            $table->datetime('AddedDate')->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->bigInteger('UpdateBy')->nullable();
            $table->bigInteger('xEmailAutoinc')->nullable();
            $table->datetime('xBillingBeginDate')->nullable();
            $table->datetime('xBillingEndDate')->nullable();
            $table->string('xStaffType', 50)->nullable();
            $table->string('xDirectory', 1)->nullable();
            $table->string('xDirectoryTitle', 100)->nullable();
            $table->string('xHidden', 1)->nullable();
            $table->datetime('xBeginDate')->nullable();
            $table->datetime('xEndDate')->nullable();
            $table->string('WebDisplay', 1)->nullable();
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
        Schema::dropIfExists('staff');
    }
}
