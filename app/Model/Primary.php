<?php

namespace App\Model;

use App\Model\Booking\Head;
use App\Model\Booking\Car;
use App\Model\Booking\Check;
use App\Model\Booking\Checks;
use App\Model\Booking\Transaction;
use App\Model\Booking\Transactions;
use App\Model\Booking\Location;
use App\Model\Booking\Employee;

class Primary implements \JsonSerializable
{
    public $head, $car, $checks, $customer, $transactions, $employee;
    public static function create($request,$nextId){
        $primary = new Primary((object)[
                    'head'      => Head::create($request,$nextId),
                    'car'       => Car::create($request),
                    'location'  => Location::create($request),
                    'employee'  => Employee::create($request),
                    ]);
        $primary->checks->compute();
        return $primary;
    }    
    public function __construct($request)
    {
        $this->head     = new Head($this, $request->head);
        $this->car      = new Car($this, $request->car);
        if (isset($request->checks)) {
            $this->checks   = new Checks($this, $request->checks); 
        } else {    
            $this->checks   = new Checks($this); 
            $this->checks->add();
        }
        if (isset($request->transactions)) {
            $this->transactions   = new Transactions($this, $request->transactions); 
        } else {    
            $this->transactions   = new Transactions($this); 
        }
        $this->location = new Location($this, $request->location);
        $this->employee = new Employee($this, $request->location);
    }
    public function jsonSerialize() {
        return [
            'head'          => $this->head,
            'car'           => $this->car,
            'customer'      => $this->customer ?? (object)[],
            'checks'        => $this->checks,
            'transactions'  => $this->transactions ?? (object)[],
            'location'      => $this->location,
            'employee'      => $this->employee,
        ];
    }
}

