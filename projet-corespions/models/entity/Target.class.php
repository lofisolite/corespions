<?php

class Target
{
    private $id;
    private $codeName;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $codeCountry;
    private $country;

    public function __construct($id, $codeName, $firstname, $lastname, $birthdate, $codeCountry, $country){
        $this -> id = $id;
        $this -> codeName = $codeName;
        $this -> firstname = $firstname;
        $this -> lastname = $lastname;
        $this -> birthdate = $birthdate;
        $this -> codeCountry = $codeCountry;
        $this -> country = $country;
    }

    public function getId(){ return $this->id; }
    public function SetId($id){ $this->id = $id; }

    public function getCodeName(){ return $this->codeName; }
    public function setCodeName($codeName){ $this->codeName = $codeName; }

    public function getFirstname(){ return $this->firstname; }
    public function setFirstname($firstname){ $this->firstname = $firstname; }

    public function getLastname(){ return $this->lastname; }
    public function setLastname($lastname){ $this->lastname = $lastname; }

    public function getBirthdate(){ return $this->birthdate; }
    public function setBirthdate($birthdate){ $this->birthdate = $birthdate; }

    public function getCodeCountry(){ return $this->codeCountry; }
    public function setCodeCountry($codeCountry){ $this->codeCountry = $codeCountry; }

    public function getCountry(){ return $this->country; }
    public function setCountry($country){ $this->country = $country; }
}