<?php

namespace App\Model\Booking;


class Transaction extends Elem implements \JsonSerializable
{
    protected $xn, $cn, $status, $type, $employeeId;
    protected $amount, $applied, $balance, $change, $tip, $created;
    
    public static function create($primary, $cn, $amount, $type = null, $employeeId = null,$tip = null){
         $tran = (object)[
            'xn'            => null,
            'cn'            => $cn,
            'status'        => null,
            'type'          => $type ?? 'Cash',
            'employeeId'    => null,
            'amount'        => $amount ?? 0,
            'applied'       => $amount ?? 0,
            'balance'       => 0,
            'change'        => 0,
            'tip'           => $tip ?? 0,
            'created'       => time(),
        ];
        return new static($primary, $tran);
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
            'xn'            => $this->xn,
            'cn'            => $this->cn,
            'status'        => $this->status,
            'type'          => $this->type,
            'employeeId'    => $this->employeeId,
            'amount'        => $this->amount,
            'applied'       => $this->applied,
            'balance'       => $this->balance,
            'change'        => $this->change,
            'tip'           => $this->tip,
            'created'       => $this->created,
        ];

    }
}
