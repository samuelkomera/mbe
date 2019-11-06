<?php

namespace App\Model\Booking;

abstract class Container implements \JsonSerializable, \IteratorAggregate
{
    const keyName = 'unknown'; // derived classes override

    protected $primary;
    private $elems, $min, $max;

    public function __construct($primary, $container = null)
    {
        $this->primary = $primary;
        $elems = new \StdClass();
        if ($container) {
            //                  remove the 's' suffix --v
            $elemClass = substr(get_called_class(), 0, -1);
            foreach ($container as $key => $obj) {
                $elems->$key = new $elemClass($primary, $obj);
            }
        }
        $this->elems = $elems;
        $this->setRange();
    }
    public function getCount()
    {   
        return count(get_object_vars($this->elems));
    }
     public function &__get($key)
    {
        return $this->elems->$key;
    }
    public function __isset($key)
    {
        return isset($this->elems->$key);
    }
    public function __set($key, $value)
    {
        // catch typos or improper use (only addElem() allowed).
        throw new np\Exception('invalid.value', get_called_class() .  "->$key");
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->elems);
    }
    public function addElem($value)
    {
        $key = ++$this->max;
        $value->{static::keyName} = $key;
        $this->elems->{$key} = $value;
        return $key;
    }
    public function removeElem($key)
    {
        unset($this->elems->$key);
        $this->setRange();
    }
    public function removeAll()
    {
        $this->elems = new \StdClass();
        $this->setRange();
    }

    public function getMin()
    {
        return $this->min;
    }
    public function getNext()
    {
        return $this->max + 1;
    }
    public function jsonSerialize()
    {
        return $this->elems;
    }
    public function checkExist($key)
    {
        if (!isset($this->$key)) {
            $short = substr(strrchr(get_called_class(), '\\'), 1, -1);
            throw new np\NoExist($short, $key);
        }
        return $this->$key;
    }
    public function asArray()
    {
        return array_values(get_object_vars($this->elems));
    }

    private function setRange()
    {
        $keys = array_keys(get_object_vars($this->elems));
        if (count($keys)) {
            $this->min = min($keys);
            $this->max = max($keys);
        } else {
            $this->min = 1;
            $this->max = 0;
        }
    }
}

