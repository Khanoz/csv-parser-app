<?php

namespace App\Library;



Class NewCsvValue{

    public $file0Field;
    public $file1Field;
    public $idFile0;
    public $idFile1;
    public $isValid;
    public $time;

    public function __construct($file0Field, $Id0){

        $this->file0Field = $file0Field;
        $this->idFile0 = $Id0;
        $this->file1Field = "";
        $this->idFile1 = "";
        $this->isValid = False;
        $this->time = date("Y-m-d h:i:sa");
    }

    public function addEqualField($file1Field, $Id1){
        $this->file1Field = $file1Field;
        $this->idFile1 = $Id1;
        $this->isValid = True;
        $this->time = date("Y-m-d h:i:sa");
    }
}


?>