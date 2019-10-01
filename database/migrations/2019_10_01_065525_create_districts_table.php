<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10);
            $table->string('name', 28);
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
        Schema::dropIfExists('districts');
    }
}
