<?php

namespace App\Services;

use App\Models\RoomReservation;
use App\Services\abstracts\AbstractService;

class ListReservationService extends AbstractService
{

    /**
     * Function returns reservations for 5 next days
     *
     * @return mixed
     */
    public function getList()
    {
        $dateFrom = date('Y-m-d H:i:s', strtotime('today midnight'));
        $dateTo = date('Y-m-d H:i:s', strtotime(' + 6 days midnight - 1 sec'));

        $reservations = RoomReservation::select('start_date', 'end_date')
            ->where('room_id', $this->data['room_id'])
            ->whereBetween('start_date', [$dateFrom, $dateTo]);

        return $reservations->get();
    }

    /**
     * Function returns reservations by date and room_id
     *
     * @return mixed
     */
    public function getAdminList()
    {
        $dateFrom = date('Y-m-d H:i:s', strtotime($this->data['date_from']));
        $dateTo = date('Y-m-d H:i:s', strtotime($this->data['date_to']));

        $reservations = RoomReservation::where('room_id', $this->data['room_id'])
            ->whereBetween('start_date', [$dateFrom, $dateTo])
            ->orderBy('start_date')
            ->get();

        return $reservations;
    }

}