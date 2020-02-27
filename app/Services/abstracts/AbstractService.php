<?php

namespace App\Services\abstracts;

class AbstractService
{

    /**
     * @var array
     */
    public $data;

    /**
     * CancelReservationService constructor.
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

}