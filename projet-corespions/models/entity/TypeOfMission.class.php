<?php

class TypeOfMission
{
    private $name;
    private $id;

    public function __construct($id, $name){
        $this->id = $id;
        $this-> name = $name;
    }

    public function getId(){ return $this->id; }
    public function SetId($id){ $this->id = $id; }

    public function getName() { return $this->name;}
    public function setName($name){ return $this->name = $name;}
}
