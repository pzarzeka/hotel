<?php

namespace App\Services;

use App\Models\RoomReservation;
use App\Services\abstracts\AbstractService;

class AddReservationService extends AbstractService
{

    /**
     * Function make reservation
     *
     * @return mixed
     */
    public function makeReservation()
    {
        $model = new RoomReservation($this->getData());
        $model->save();

        return $model->id;
    }

}