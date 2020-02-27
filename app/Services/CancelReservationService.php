<?php

namespace App\Services;

use App\Models\RoomReservation;
use App\Services\abstracts\AbstractService;

class CancelReservationService extends AbstractService
{
    /**
     * Function cancel reservation
     *
     * @return boolean
     */
    public function cancelReservation()
    {
        $status = true;
        $reservation = RoomReservation::where('id', $this->data['reservation_id'])
            ->where('room_id', $this->data['room_id'])
            ->first();

        $reservation->delete();

        return $status;
    }

}