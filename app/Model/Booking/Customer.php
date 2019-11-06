<?php

namespace App\Model\Booking;


class Customer implements \JsonSerializable
{
    public function __construct($request)
    {
        $this->make = $request->make;
        $this->model = $request->model;
    }
    public function jsonSerialize() {
        return [
            'make'  => $this->make,
            'model' => $this->model,
        ];
    }
}

