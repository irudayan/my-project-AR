<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagesection', function (Blueprint $table) {
            $table->id();
            $table->string('Name', 255)->nullable();
            $table->string('MainsectionName',255)->nullable();
            $table->string('SubsectionName',255)->nullable();
            $table->text('Description')->nullable();
            $table->bigInteger('Position')->nullable();
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
        Schema::dropIfExists('pagesection');
    }
}
