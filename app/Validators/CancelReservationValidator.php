<?php

namespace App\Validators;

use App\Models\RoomReservation;
use App\Validators\abstracts\AbstractReservationValidator;
use Illuminate\Support\Facades\Validator;

class CancelReservationValidator extends AbstractReservationValidator
{
    const RESERVATION_DOESNT_EXISTS_ERROR_TEXT = 'Reservation doesn\'t exist.';
    const TOO_MANY_RESERVATION_ERROR_TEXT = 'Too many reservations with those parameters.';
    const RESERVATION_DELETED_TEXT = 'Reservation has been deleted.';

    /**
     * validations rules for params
     *
     * @var array
     */
    protected $rules = [
        'reservation_id' => 'required|integer',
        'room_id' => 'required|integer',
    ];

    /**
     * Function validates params for cancel reservation
     *
     * @return bool
     */
    public function validate()
    {
        $validate = true;

        $validator = Validator::make($this->getData(), $this->getRules());
        if ($validator->fails()) {
            $validate = false;
            $this->setErrors($validator->errors()->all());
        }

        $reservation = RoomReservation::where('id', $this->data['reservation_id'])
            ->where('room_id', $this->data['room_id'])
            ->get();

        if ($reservation->count() === 0) {
            $validate = false;
            $this->setError(self::RESERVATION_DOESNT_EXISTS_ERROR_TEXT);
        } else if ($reservation->count() > 1) {
            $validate = false;
            $this->setError(self::TOO_MANY_RESERVATION_ERROR_TEXT);
        }

        return $validate;
    }

}