<?php

class Admin
{
    private $id;
    private $login;
    private $password;

    public function __construct($id, $login, $password){
        $this -> id = $id;
        $this -> login = $login;
        $this -> password = $password;
    }
    
    public function getId(){ return $this->id; }

    public function getLogin(){ return $this->login; }

    public function getPassword(){ return $this->password; }
}
