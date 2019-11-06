<?php

namespace App\Model\Booking;


class Check extends Elem implements \JsonSerializable
{
    public $price,$adjprice,$balance,$created,$total,$tax,$subtotal,$due,$days;
    public static function create($primary){
        return new static($primary, (object)[
            'price'     => 0,
            'adjprice'  => null,
            'days'      => 0,
            'total'     => 0,
            'subtotal'  => 0,
            'due'       => 0, //total - subtotal
            'balance'   => 0,
            'tax'       => 0,
            'created'   => time(),
        ]);
    }
    public function compute() 
    {
        $primary = $this->primary;
        $car        = $primary->car;
        $head       = $primary->head;
        $day = 86400;
        $days = 1;
        $balance = 0; 
        $starttime = $head->starttime;
        $endtime   = $head->endtime;
        $price     = $car->price;
        $adjPrice  = $car->adjprice;
        $deposit   = $car->deposit ?? 0;
        if ($starttime && $endtime) {
            $totalTime = $endtime - $starttime;
            $days = round($totalTime / $day);
        }
        $total  = ($adjPrice) ? $days*$adjPrice : $days*$price;
        $due    = $total - $deposit;
        $due    = ($due >= 0) ? $due : 0; 
        $subtotal = 0;
        if ($subtotal > $total) {
            $balance = $subtotal - $total; 
        }
        $this->days = $days; 
        $this->price = $price; 
        $this->adjprice = $adjPrice; 
        $this->due = $due;
        $this->balance = $balance;
        $this->total = $total;
        $this->subtotal = $subtotal;
         
    }
//    public function __construct($request)
//    {
//          parent::__construct($request);
//    }
    public function jsonSerialize() {
        return [
            'price'     => $this->price,
            'adjprice'  => $this->adjprice,
            'total'     => $this->total,
            'days'      => $this->days,
            'subtotal'  => $this->subtotal,
            'due'       => $this->due,
            'balance'   => $this->balance,
            'tax'       => $this->tax,
            'created'   => $this->created,
        ];
    }
}
