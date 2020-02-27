<?php

namespace App\Validators;

use App\Models\Room;
use App\Models\RoomReservation;
use App\Validators\abstracts\AbstractReservationValidator;

class AvailableReservationValidator extends AbstractReservationValidator
{

    const HOUR_IN_SECONDS = 3600;
    const DAY_IN_SECONDS = 24 * 3600;

    const INVALID_DATE_FORMAT_ERROR_TEXT = 'Invalid date format. Hour have to be full.';
    const UNAVAILABLE_RESERVATION_ERROR_TEXT = 'Reservation not available. Please choose different time.';
    const ROOM_DOESNT_EXIST_ERROR_TEXT = 'Room doesn\'t exist. Please choose different room.';
    const RESERVATION_TIME_IS_TOO_EARLY_ERROR_TEXT = 'Reservation date is too early. ';
    const RESERVATION_TIME_IS_TOO_LONG_ERROR_TEXT = 'Reservation date is too long. ';
    const INVALID_END_DATE_ERROR_TEXT = 'Invalid end date reservation';
    const INVALID_DATES_ERROR_TEXT = 'Invalid time reservation. Max reservation time: 1h.';

    /**
     * Function validates conditions to make a reservation
     *
     * @return bool|int
     */
    public function validate()
    {
        $validate = true;

        $validate = $this->checkDateFormat()
        & $this->checkExistsRoom()
        & $this->checkReservationDate()
        & $this->checkAvailableReservation()
        & $this->validateReservationDates();

        return $validate;
    }

    /**
     * Function checks passed dates format
     *
     * @return bool
     */
    public function checkDateFormat()
    {
        $validate = true;
        if (strtotime($this->data['start_date']) % self::HOUR_IN_SECONDS !== 0
            || strtotime($this->data['end_date']) % self::HOUR_IN_SECONDS !== 0
        ) {
            $validate = false;
            $this->setError(self::INVALID_DATE_FORMAT_ERROR_TEXT);
        }

        return $validate;
    }

    /**
     * Function checks if room exist
     *
     * @return bool
     */
    public function checkExistsRoom()
    {
        $validate = true;
        $rooms = Room::where('id', $this->data['room_id'])->first();

        if (empty($rooms)) {
            $validate = false;
            $this->setError(self::ROOM_DOESNT_EXIST_ERROR_TEXT);
        }

        return $validate;
    }

    /**
     * Function checks if reservation is available
     *
     * @return bool
     */
    public function checkAvailableReservation()
    {
        $validate = true;
        $reservations = RoomReservation::where('start_date', $this->data['start_date'])
            ->where('end_date', $this->data['end_date'])
            ->where('room_id', $this->data['room_id'])
            ->get();

        if ($reservations->count() !== 0) {
            $validate = false;
            $this->setError(self::UNAVAILABLE_RESERVATION_ERROR_TEXT);
        }

        return $validate;
    }

    /**
     * Function checks if reservation is possible
     *
     * @return bool
     */
    public function checkReservationDate()
    {
        $validate = true;
        $diffTime = strtotime($this->data['start_date']) - time();
        if ($diffTime < self::DAY_IN_SECONDS) {
            $validate = false;
            $this->setError(self::RESERVATION_TIME_IS_TOO_EARLY_ERROR_TEXT);
        }

        if ($diffTime > 5 * self::DAY_IN_SECONDS) {
            $validate = false;
            $this->setError(self::RESERVATION_TIME_IS_TOO_LONG_ERROR_TEXT);
        }

        return $validate;
    }

    /**
     * Function checks dates correctness
     *
     * @return bool
     */
    public function validateReservationDates()
    {
        $validate = true;
        $startDate = strtotime($this->data['start_date']);
        $endDate = strtotime($this->data['end_date']);
        if ($startDate > $endDate || $startDate === $endDate) {
            $validate = false;
            $this->setError(self::INVALID_END_DATE_ERROR_TEXT);
        }

        if (($endDate - $startDate) !== self::HOUR_IN_SECONDS) {
            $validate = false;
            $this->setError(self::INVALID_DATES_ERROR_TEXT);
        }

        return $validate;
    }

}