<?php

require_once "models/manager/MissionManager.class.php";

class MissionController
{
    private $missionManager;

    public function __construct(){
        $this-> missionManager = new MissionManager();
        $this-> missionManager->loadMissions();
    }

    public function giveMissions(){
        return $this->missionManager->getMissions();
    }

    public function giveMissionDetails($id){
        return $this->missionManager->getMissionById($id);
    }

    public function giveMissionsBySpy($spyId){
        $this->missionManager->loadMissionsBySpy($spyId);
        return $this->missionManager->getMissionsBySpy();
    }

    public function giveMissionsByTarget($targetId){
        $this->missionManager->loadMissionsByTarget($targetId);
        return $this->missionManager->getMissionsByTarget();
    }

    public function giveMissionsByContact($contactId){
        $this->missionManager->loadMissionsByContact($contactId);
        return $this->missionManager->getMissionsByContact();
    }

    public function giveMissionsByHideout($hideoutId){
        $this->missionManager->loadMissionsByHideout($hideoutId);
        return $this->missionManager->getMissionsByHideout();
    }

    // fonctions requêtes mission
    public function addMissionInBdd($title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate){
        $this->missionManager->addMissionInBdd($title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate);
    }

    public function modifyMissionInBdd($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate){
        $this->missionManager->modifyMissionInBdd($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate);
    }

    public function deleteMission($idMission){
        $this->missionManager->deleteMissionInBdd($idMission);
    }

    public function getLastIdMission(){
        return $this->missionManager-> getLastIdMission(); 
    }
}