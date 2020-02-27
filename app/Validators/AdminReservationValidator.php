<?php


namespace App\Validators;


use App\Validators\abstracts\AbstractReservationValidator;
use Illuminate\Support\Facades\Validator;

class AdminReservationValidator extends AbstractReservationValidator
{
    /**
     * validations rules for params
     *
     * @var array
     */
    protected $rules = [
        'room_id' => 'required|integer',
        'date_from' => 'required|date',
        'date_to' => 'required|date',
    ];

    /**
     * Function validate
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

        return $validate;
    }

}