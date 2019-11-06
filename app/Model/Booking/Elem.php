<?php

namespace App\Model\Booking;


class Elem
{
    protected $primary;

    public function __construct($primary, $obj = null)
    {
        if (is_object($obj) || is_array($obj)) { // shallow copy
            foreach ($obj as $name => $value) {
                // avoid throwing in __set to handle cases were we removed
                // a property in code, but database still has it.
                if (property_exists($this, $name)) {
                    $this->$name = $value;
                }
            }
        }
        $this->primary = $primary;
    }
}
