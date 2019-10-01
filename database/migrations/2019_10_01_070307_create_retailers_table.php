<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 64);
            $table->bigInteger('town_id')->unsigned();
            $table->foreign('town_id')->references('id')->on('towns');
            $table->string('ownername', 128);
            $table->string('shopname', 128);
            $table->string('rmn', 20);
            $table->string('email', 128);
            $table->string('hq', 64);
            $table->string('dsh', 64);
            $table->string('rh', 64);
            $table->string('scheme', 128);
            $table->enum('active', ['0', '1'])->default('1');
            $table->enum('deleted', ['0', '1'])->default('0');
            $table->bigInteger('createdbyuserid')->unsigned();
            $table->foreign('createdbyuserid')->references('id')->on('users');
            $table->bigInteger('updatedbyuserid')->unsigned();
            $table->foreign('updatedbyuserid')->references('id')->on('users');
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
        Schema::dropIfExists('retailers');
    }
}
