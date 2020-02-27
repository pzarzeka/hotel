<?php

use App\Room;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class HotelRooms extends Migration
{
    public $rooms = [
        'white', 'sea', 'red', 'black', 'blue', 'green', 'yellow', 'orange', 'silver', 'gold'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasTable('rooms')) {
            $this->createRooms();
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
    }

    private function createRooms() {
        foreach ($this->rooms as $room) {
            $object = new Room(['name' => $room]);
            $object->save();
        }
    }
}
