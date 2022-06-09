<?php

class Node
{

    public $id;
    public $name;
    public $leftValue;
    public $rightValue;

    function __construct($id, $name, $leftValue, $rightValue) {
        $this->id = $id;
        $this->name = $name;
        $this->leftValue = $leftValue;
        $this->rightValue = $rightValue;
    }

}