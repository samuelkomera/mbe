<?php

namespace App\Model\Booking;

class Employee extends Elem implements \JsonSerializable
{
    public $pickup,$dropoff;
    public static function create($request)
    {
        return new static(null, (object)[
            'pickup'   => $request->pickup ?? null,
            'dropoff'  => $request->dropoff ?? null
        ]);
    }
    public function __construct($primary, $request)
    {
        parent::__construct($primary,$request);
    }
    public function jsonSerialize() {
        return [
            'pickup'  => $this->pickup,
            'dropoff' => $this->dropoff
        ];
    }
}

