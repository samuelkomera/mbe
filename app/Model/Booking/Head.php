<?php

namespace App\Model\Booking;


class Head extends Elem implements \JsonSerializable
{
    public $id,$starttime,$endtime,$cstarttime,$cendtime,$created,$modified,$status;
    public static function create($request,$nextId){
        return new static(null, (object)[
            'id'            => $nextId,
            'starttime'     => $request->starttime,
            'endtime'       => $request->endtime,
            'cstarttime'    => null,
            'cendtime'      => null,
            'created'       => time(),
            'modified'      => time(),
            'status'        => 'booked'
        ]);
    }
    public function __construct($primary, $request)
    {
          parent::__construct($primary, $request);
    }
    public function jsonSerialize() {
        return [
            'id'        => $this->id,
            'starttime' => $this->starttime,
            'endtime'   => $this->endtime,
            'cstarttime'=> $this->cstarttime,
            'cendtime'  => $this->cendtime,
            'created'   => $this->created,
            'modified'  => $this->modified,
            'status'    => $this->status
        ];
    }
}

