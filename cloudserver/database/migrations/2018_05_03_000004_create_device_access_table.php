<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_access', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
			$table->integer('device_id')->unsigned();
			$table->primary(['user_id', 'device_id']);
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('device_id')->references('id')->on('device');
			
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
        Schema::dropIfExists('device_access');
    }
}
