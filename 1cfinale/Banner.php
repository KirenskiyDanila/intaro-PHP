<?php

class Banner
{
    public $name;
    public $count;
    public $proportion;

    function __construct($name, $count) {
        $this->name = $name;
        $this->count = $count;
        $this->proportion = 0;
    }
}