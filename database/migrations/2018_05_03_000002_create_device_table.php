<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('id_in_residence');
			$table->string('device_name');
			$table->integer('raspberry_id')->unsigned();
			$table->unique(array('id_in_residence', 'raspberry_id'));
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
