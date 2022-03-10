<?php

class Hideout
{
    private $id;
    private $codeName;
    private $address;
    private $codeCountry;
    private $country;
    private $type;

    public function __construct($id, $codeName, $address, $codeCountry, $country, $type){
        $this -> id = $id;
        $this -> codeName = $codeName;
        $this -> address = $address;
        $this -> codeCountry = $codeCountry;
        $this -> country = $country;
        $this -> type = $type;
    }

    public function getId(){ return $this->id; }
    public function SetId($id){ $this->id = $id; }

    public function getCodeName(){ return $this->codeName; }
    public function setCodeName($codeName){ $this->codeName = $codeName; }

    public function getAddress(){ return $this->address; }
    public function setAddress($address){ $this->address = $address; }

    public function getCodeCountry(){ return $this->codeCountry; }
    public function setCodeCountry($codeCountry){ $this->codeCountry = $codeCountry; }

    public function getCountry(){ return $this->country; }
    public function setCountry($country){ $this->country = $country; }

    public function getType(){ return $this->type; }
    public function setType($type){ $this->type = $type; }
}