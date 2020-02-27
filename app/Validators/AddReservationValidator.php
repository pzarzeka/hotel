<?php

namespace App\Validators;

use App\Validators\abstracts\AbstractReservationValidator;
use Illuminate\Support\Facades\Validator;

class AddReservationValidator extends AbstractReservationValidator
{
    /**
     * Validations rules for params
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|alpha',
        'second_name' => 'required|alpha',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'room_id' => 'required|integer'
    ];

    /**
     * Function validates params for making reservation
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

        $availableValidator = new AvailableReservationValidator($this->getData());
        if (!$availableValidator->validate()) {
            $validate = false;
            $this->setErrors($availableValidator->getErrors());
        }

        return $validate;
    }

}