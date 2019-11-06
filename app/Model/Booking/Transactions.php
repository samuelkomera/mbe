<?php

namespace App\Model\Booking;

class Transactions extends Container
{
    const keyName = 'tn';

    public function add($cn, $type, $amount, $employeeId = null, $tip = null)
    {
        $primary = $this->primary;
        $this->addElem(Transaction::create($primary, $cn, $amount, $type));
    }
    public function compute()
    {
        foreach ($this as $tn => $tran) {
            $tran->compute();
        }
    }
}
