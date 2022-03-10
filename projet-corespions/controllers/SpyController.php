<?php

require_once "models/manager/SpyManager.class.php";

class SpyController
{
    private $spyManager;

    public function __construct(){
        $this-> spyManager = new SpyManager();
        $this-> spyManager->loadSpies();
    }

    public function displaySpies(){
        $spies = $this->spyManager->getSpies();
        require_once "views/displayAll/spies.view.php";
    }

    public function giveSpyDetails($idSpy){
        return $this->spyManager->getSpieById($idSpy);
    }
    
    public function giveSpiesByMission($idMission){
        $this->spyManager->loadSpiesByMission($idMission);
        return $this->spyManager->getSpiesByMission();
    }

    public function giveSpiesIdByMission($idMission){
        return $this->spyManager->loadSpiesIdByMission($idMission);
    }

    public function giveSpies(){
        return $this->spyManager->getSpies();
    }

    public function getLastIdSpy(){
        return $this->spyManager-> getLastIdSpy(); 
    }

    // fonctions requêtes spy
    public function addSpyInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
        $this->spyManager->addSpyInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);
    }

    public function modifySpyInBdd($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
        $this->spyManager->modifySpyInBdd($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);
    }

    public function deleteSpyInBdd($idSpy){
        return $this->spyManager->deleteSpyInBdd($idSpy);
    }
    
    // fonctions requêtes Bdd spy liées aux missions
    public function addSpiesByMissionInBdd($idMission, $spies){
        $this->spyManager->addSpiesByMissionInBdd($idMission, $spies);
    }

    public function modifySpiesByMissionInBdd($idMission, $spies){
            $this->spyManager->modifySpiesByMissionInBdd($idMission, $spies);
    }
    
    public function deleteSpiesByMissionInBdd($idMission){
        $this->spyManager->deleteSpyByMissionInBdd($idMission);
    }
}
