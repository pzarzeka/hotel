<?php

namespace App\Validators\abstracts;

abstract class AbstractReservationValidator
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @var array
     */
    public $errors = [];

    /**
     * AbstractReservationValidator constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->setData($data);
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $errors
     */
    public function setErrors($errors)
    {
        foreach ($errors as $error) {
            $this->setError($error);
        }
    }

    /**
     * @param $error
     */
    public function setError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

}