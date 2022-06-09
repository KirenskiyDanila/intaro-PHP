<?php

class Advertising
{
    public $name;
    public $count;
    public $time;

    function __construct($name, $count, $time) {
        $this->name = $name;
        $this->count = $count;
        $this->time = date_create($time);
    }
}