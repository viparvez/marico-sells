<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailauthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailauthentications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 128);
            $table->string('password', 128);
            $table->string('incoming_server', 128);
            $table->string('incoming_protocol', 20);
            $table->string('outgoing_server', 128);
            $table->string('outgoing_protocol', 20);
            $table->string('incoming_port', 8);
            $table->string('outgoing_port', 8);
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
        Schema::dropIfExists('emailauthentications');
    }
}
