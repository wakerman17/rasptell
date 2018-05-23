<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaspberryForUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raspberry_for_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
			$table->integer('raspberry_id')->unsigned();
			$table->primary(['user_id', 'raspberry_id']);
			$table->foreign('user_id')->references('id')->on('user');
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
        Schema::dropIfExists('raspberry_for_user');
    }
}
