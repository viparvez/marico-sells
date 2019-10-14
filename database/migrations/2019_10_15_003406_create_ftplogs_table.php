<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtplogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftplogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('executed_on');
            $table->String('file_path', 128);
            $table->boolean('success');
            $table->bigInteger('ftp_id')->unsigned();
            $table->foreign('ftp_id')->references('id')->on('ftpauthentications');
            $table->bigInteger('createdbyuserid')->unsigned()->nullable();
            $table->foreign('createdbyuserid')->references('id')->on('users');
            $table->bigInteger('updatedbyuserid')->unsigned()->nullable();
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
        Schema::dropIfExists('ftplogs');
    }
}
