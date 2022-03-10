<?php

require_once "models/manager/SpecialityManager.class.php";

class SpecialityController
{
    private $specialityManager;

    public function __construct(){
        $this-> specialityManager = new SpecialityManager();
        $this-> specialityManager->loadSpecialities();
    }

    public function giveSpecialities(){
        return $this->specialityManager->getSpecialities();
    }

    public function giveSpecialityByMission($idMission){
        $this->specialityManager->loadSpecialityByMission($idMission);
        return $this->specialityManager->getSpecialityByMission();
    }

    public function giveSpecialitiesBySpy($idSpy){
         $this->specialityManager->loadSpecialitiesBySpy($idSpy);
        return $this->specialityManager->getSpecialitiesBySpy();
    }

    public function giveSpecialitiesIdBySpy($idSpy){
        return $this->specialityManager->loadSpecialitiesIdBySpy($idSpy);
    }

    public function giveAllSpecialitiesBySpies(){
        return $this->specialityManager->loadAllSpecialitiesBySpy();
    }

    // requête Bdd spécialité
    public function addSpecialityInBdd(){
        $specialitiesIdByMission = $this->specialityManager->loadAllSpecialitiesIdByMission();
        $specialitiesIdBySpy = $this->specialityManager->loadAllSpecialitiesIdBySpy();
        $specialities = $this->specialityManager->getSpecialities();
        $error = '';

        if(isset($_POST['name']) && !empty($_POST['name'])){
            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['name'])){
                $name = secureData($_POST['name']);

                // appel fonction ajout Bdd
                $this->specialityManager->addSpecialityInBdd($name);

                $_SESSION['alert'] = [
                    "type" => "success",
                    "msg" => "La spécialité a bien été ajoutée"         
                ];

                header('Location: '. URL . "specialities/add");
                            
            } else {
                $error = 'Il y a des caractères non autorisés';
            }
          } else {
              $error = "";
        }

        require_once "views/addEntity/specialityAdd.view.php";
    }

    
    public function modifySpecialityInBdd($specialityId){
        $speciality = $this->specialityManager->getSpecialityById($specialityId);
        
        if(isset($_POST['name']) && !empty($_POST['name'])){
            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['name'])){
                $name = secureData($_POST['name']);

                // appel fonction ajout Bdd
                $this->specialityManager->modifyspecialityInBdd($specialityId, $name);

                $_SESSION['alert'] = [
                    "type" => "success",
                    "msg" => "La spécialité a bien été modifié"         
                ];

                header('Location: '. URL . "specialities/add");
                            
            } else {
                $error = 'Il y a des caractères non autorisés';
            }
          } else {
              $error = "";
        }
        

        require_once "views/modifyEntity/specialityModify.view.php";
    }

    public function deleteSpecialityInBdd($specialityId){
        if($this->specialityManager->deleteSpecialityInBdd($specialityId)){
            $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "La spécialité a bien été supprimée"         
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "La spécialité n'a pas été supprimé"         
            ];
        }

        header('Location: '. URL . "specialities/add");
    }

        // requête Bdd spécialité lié aux missions
    public function addSpecialityByMissionInBdd($idMission, $speciality){
        $this->specialityManager->addSpecialityByMissionInBdd($idMission, $speciality);
    }
    
    public function modifySpecialityByMissionInBdd($idMission, $speciality){
        $this->specialityManager->modifySpecialityByMissionInBdd($idMission, $speciality);
    }
    
    public function deleteSpecialityByMissionInBdd($idMission){
        $this->specialityManager->deleteSpecialityByMissionInBdd($idMission);
    }

        // Requête Bdd spécialité lié aux agents.
    public function addSpecialitiesBySpyInBdd($idSpy, $specialities){
        $this->specialityManager->addSpecialitiesBySpyInBdd($idSpy, $specialities);
    }

    public function modifySpecialitiesBySpyInBdd($idspy, $specialities){
        $this->specialityManager->modifySpecialitiesBySpyInBdd($idspy, $specialities);
    }

    public function deleteSpecialitiesBySpyInBdd($idSpy){
        $this->specialityManager->deleteSpecialitiesBySpyInBdd($idSpy);
    }
}
