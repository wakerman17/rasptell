<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesOfHouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_of_house', function (Blueprint $table) {
            $table->increments('id');
			$table->string('lampName');
			$table->integer('raspberry_id')->unsigned();
			$table->foreign('raspberry_id')->references('id')->on('raspberry');
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
        Schema::dropIfExists('devices_of_house');
    }
}
