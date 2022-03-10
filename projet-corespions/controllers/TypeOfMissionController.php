<?php

require_once "models/manager/TypeOfMissionManager.class.php";

class TypeOfMissionController
{
    private $typeOfMissionManager;

    public function __construct(){
        $this-> typeOfMissionManager = new TypeOfMissionManager();
        $this-> typeOfMissionManager->loadTypesOfMission();
    }

    public function giveTypesOfMission(){
        return $this->typeOfMissionManager->getTypesOfMission();
    }

    public function giveTheTypeOfMissionByMission($idMission){
        $this->typeOfMissionManager->loadTypeOfMissionByMission($idMission);
        return $this->typeOfMissionManager->getTypeOfMissionByMission();
    }

        public function giveAllTypeOfMissionByMission(){
        return $this->typeOfMissionManager->loadAllTypesOfMissionByMission();
    }

    public function giveTypeOfMissionDetails($typeOfMissionId){
        return $this->typeOfMissionManager->getTypeOfMissionById($typeOfMissionId);
    }

    // requête Bdd type de mission
    public function addTypeOfMissionInBdd(){
        $typOfMissionIdByMission = $this->typeOfMissionManager->loadTypeOfMissionIdByMission();
        $types = $this->typeOfMissionManager->getTypesOfMission();

        if(isset($_POST['name']) && !empty($_POST['name'])){
            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['name'])){
                $name = secureData($_POST['name']);

                // appel fonction ajout Bdd
                $this->typeOfMissionManager->addTypeOfMissionInBdd($name);

                $_SESSION['alert'] = [
                    "type" => "success",
                    "msg" => "Le type de mission a bien été ajouté"         
                ];

                header('Location: '. URL . "typesOfMission/add");
                            
            } else {
                $error = 'Il y a des caractères non autorisés';
            }
          } else {
              $error = "";
        }

        require_once "views/addEntity/typesOfMissionAdd.view.php";
    }

    public function modifyTypeOfMissionInBdd($typeOfMissionId){
        $type = $this->typeOfMissionManager->getTypeOfMissionById($typeOfMissionId);
        
        if(isset($_POST['name']) && !empty($_POST['name'])){
            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['name'])){
                $name = secureData($_POST['name']);

                // appel fonction ajout Bdd
                $this->typeOfMissionManager->modifyTypeOfMissionInBdd($typeOfMissionId, $name);

                $_SESSION['alert'] = [
                    "type" => "success",
                    "msg" => "Le type de mission a bien été modifié"         
                ];

                header('Location: '. URL . "typesOfMission/add");
                            
            } else {
                $error = 'Il y a des caractères non autorisés';
            }
          } else {
              $error = "";
        }
        

        require_once "views/modifyEntity/typesOfMissionModify.view.php";
    }

    public function deleteTypeOfMissionInBdd($typeOfMissionId){
        if($this->typeOfMissionManager->deleteTypeOfMissionInBdd($typeOfMissionId)){
            $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Le type de mission a bien été supprimé"         
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "Le type de mission ne peut pas être supprimé."         
            ];
        }

        header('Location: '. URL . "typesOfMission/add");
    }

    // requête Bdd type de mission lié aux missions
    public function addTypeOfMissionByMissionInBdd($idMission, $typeOfMission){
        $this->typeOfMissionManager->addTypeOfMissionByMissionInBdd($idMission, $typeOfMission);
    }

    public function modifyTypeOfMissionByMissionInBdd($idMission, $typeOfMission){
        $this->typeOfMissionManager->modifyTypeOfMissionByMissionInBdd($idMission, $typeOfMission);
    }

    public function deleteTypeOfMissionByMissionInBdd($idMission){
        $this->typeOfMissionManager->deleteTypeOfMissionByMissionInBdd($idMission);
    }

}

