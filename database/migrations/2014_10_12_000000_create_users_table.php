<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('usertype', ['Users', 'Pastor', 'Admin','District'])->default('Users');
            $table->enum('status', ['Active', 'Inctive'])->default('Active');
            $table->bigInteger('districtMainkey')->nullable();
            $table->bigInteger('churchMainkey')->nullable();
            $table->string('district', 250)->nullable();
            $table->string('churchdistrict', 250)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
