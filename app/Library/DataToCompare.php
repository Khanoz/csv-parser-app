<?php

namespace App\Library;

class DataToCompare{
    public $real;
    public $dirty;
    
    public function __construct($r, $d){
        $this->real = $r;
        $this->dirty = $d;
    }
}



?>