<?php

use App\Room;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rooms_reservations')) {
            Schema::create('rooms_reservations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50);
                $table->string('second_name', 50);
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->integer('room_id')->unsigned();
                $table->foreign('room_id')->references('id')->on('rooms');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('rooms_reservations');
    }
}
