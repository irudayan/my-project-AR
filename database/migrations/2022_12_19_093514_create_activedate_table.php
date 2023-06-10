<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivedateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activedate', function (Blueprint $table) {
            $table->id();
            $table->date('ActivedDate')->format('mm/dd/Y');
            $table->date('EndDate')->format('mm/dd/Y');
            $table->string('Comments');
            $table->string('Rolestype');
            $table->year('Year');  
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
        Schema::dropIfExists('activedate');
    }
}
