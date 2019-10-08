<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('retailer_id')->unsigned();
            $table->foreign('retailer_id')->references('id')->on('retailers');
            $table->string('orderid', 64);
            $table->string('phone', 20);
            $table->string('name', 128);
            $table->text('location');
            $table->string('businessarea', 128);
            $table->text('query');
            $table->text('request');
            $table->string('solution', 20);
            $table->string('calltype', 20);
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
        Schema::dropIfExists('orders');
    }
}
