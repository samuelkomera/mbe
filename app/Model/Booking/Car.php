<?php

namespace App\Model\Booking;


class Car extends Elem implements \JsonSerializable
{
    public $make,$model,$price,$adjprice,$carnumber;
    public static function create($request){
        return new static(null, (object)[
            'make'     => $request->make,
            'model'    => $request->model,
            'price'    => $request->price,
            'adjprice' => $request->adjprice ?? null,
            'carnumber'=> null,
        ]);
    }
    public function __construct($primary, $request)
    {
          parent::__construct($primary, $request);
    }
    public function jsonSerialize() {
        return [
            'make'     => $this->make,
            'model'    => $this->model,
            'price'    => $this->price,
            'adjprice' => $this->adjprice,
            'carnumber'=> $this->carnumber,
        ];
    }
}

