<?php

namespace App\Model\Booking;

class Location extends Elem implements \JsonSerializable
{
    public $pickup,$dropoff;

    public static function create($location = null)
    {
        return new static(null, (object)[
            'pickup'   => $location->pickup ?? null,
            'dropoff'  => $location->dropoff ?? null
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

