<?php

class Mission
{
    private $id;
    private $title;
    private $description;
    private $codeName;
    private $status;
    private $codeCountry;
    private $country;
    private $startDate;
    private $endDate;

    public function __construct($id, $title, $description, $codeName, $status, $codeCountry, $country, $startDate, $endDate){
        $this -> id = $id;
        $this -> title = $title;
        $this -> description = $description;
        $this -> codeName = $codeName;
        $this -> status = $status;
        $this -> codeCountry = $codeCountry;
        $this -> country = $country;
        $this -> startDate = $startDate;
        $this -> endDate = $endDate;
    }

    public function getId(){ return $this->id; }
    public function SetId($id){ $this->id = $id; }

    public function getTitle(){ return $this->title; }
    public function SetTitle($title){ $this->title = $title; }

    public function getDescription(){ return $this->description; }
    public function SetDescription($description){ $this->description = $description; }

    public function getcodeName(){ return $this->codeName; }
    public function SetCodeName($codeName){ $this->codeName = $codeName; }

    public function getStatus(){ return $this->status; }
    public function SetStatus($status){ $this->status = $status; }

    public function getCodeCountry(){ return $this->codeCountry; }
    public function SetCodeCountry($codeCountry){ $this->codeCountry = $codeCountry; }

    public function getCountry(){ return $this->country; }
    public function SetCountry($country){ $this->country = $country; }

    public function getStartDate(){ return $this->startDate; }
    public function SetStartDate($startDate){ $this->startDate = $startDate; }

    public function getEndDate(){ return $this->endDate; }
    public function SetEndDate($endDate){ $this->endDate = $endDate; }

}