<?php

namespace App\Model\Booking;

class Checks extends Container
{
    const keyName = 'cn';

    public function add()
    {
        $primary = $this->primary;
        $this->addElem(Check::create($primary));
    }
    public function compute()
    {
        foreach ($this as $cn => $check) {
            $check->compute();
        }
    }
}
