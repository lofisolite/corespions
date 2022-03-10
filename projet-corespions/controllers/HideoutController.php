<?php

require_once "models/manager/HideoutManager.class.php";

class HideoutController
{
    private $hideoutManager;

    public function __construct(){
        $this-> hideoutManager = new HideoutManager();
        $this-> hideoutManager->loadHideouts();
    }

    public function displayHideouts(){
        $hideouts = $this->hideoutManager->getHideouts();
        require_once "views/displayAll/hideouts.view.php";
    }

    public function giveHideouts(){
        return $this->hideoutManager->getHideouts();
    }

    public function giveHideoutDetails($idHideout){
        return $this->hideoutManager->getHideoutsById($idHideout);
    }
    
    public function giveHideoutsByMission($missionId){
        $this->hideoutManager->loadHideoutsByMission($missionId);
        return $this->hideoutManager->getHideoutsByMission();
    }

    public function giveHideoutsIdByMission($missionId){
        $hideoutsByMission = $this->hideoutManager->loadHideoutsIdByMission($missionId);
        if(isset($hideoutsByMission)){
            return $hideoutsByMission;
        } else {
            return false;
        }
    }

    // fonctions requêtes Bdd hideout
    public function addHideoutInBdd(){
        $countryArray = giveArrayCountry();

        // validation du formulaire
        $error = '';
        if(isset($_POST['codeName']) && !empty($_POST['codeName']) 
            && isset($_POST['address']) && !empty($_POST['address'])
            && isset($_POST['codeName']) && !empty($_POST['codeName'])
            && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])
            && isset($_POST['type']) && !empty($_POST['type'])
            ){

            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){
                if(preg_match('/(^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:;]+$)/i', $_POST['address'])){
                    if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['type'])){

                                $codeName = secureData($_POST['codeName']);
                                $address = secureData($_POST['address']);
                                $type = secureData($_POST['type']);
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);

                                // appel fonction ajout Bdd
                                $this->hideoutManager->addHideoutInBdd($codeName, $address, $codeCountry, $country, $type);
                                
                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "La planque a bien été ajoutée"         
                                ];

                                header('Location: '. URL . "hideouts");
                            
                    } else {
                        $error = 'Il y a des caractères non autorisés dans le type';
                    }
                } else {
                    $error = 'Il y a des caractères non autorisés dans l\'adresse';
                } 
            } else {
                $error = 'Il y a des caractères non autorisés dans le nom de code';
            }
          } else {
              $error = "";
        }

        require_once "views/addEntity/hideoutAdd.view.php";
    }
    
    public function modifyHideoutInBdd($idHideout){
        $hideout = $this->giveHideoutDetails($idHideout);
        $countryArray = giveArrayCountry();

        // validation du formulaire
        $error = '';
        if(isset($_POST['codeName']) && !empty($_POST['codeName']) 
            && isset($_POST['address']) && !empty($_POST['address'])
            && isset($_POST['codeName']) && !empty($_POST['codeName'])
            && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])
            && isset($_POST['type']) && !empty($_POST['type'])
            ){

            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){
                if(preg_match('/(^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:;]+$)/i', $_POST['address'])){
                    if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['type'])){

                                $codeName = secureData($_POST['codeName']);
                                $address = secureData($_POST['address']);
                                $type = secureData($_POST['type']);
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);

                                // appel fonction ajout Bdd
                                $this->hideoutManager->modifyHideoutInBdd($idHideout, $codeName, $address, $codeCountry, $country, $type);
                                
                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "La planque a bien été modifiée"         
                                ];

                                header('Location: '. URL . "hideouts/list/" . $hideout->getId());
                            
                    } else {
                        $error = 'Il y a des caractères non autorisés dans le type';
                    }
                } else {
                    $error = 'Il y a des caractères non autorisés dans l\'adresse';
                } 
            } else {
                $error = 'Il y a des caractères non autorisés dans le nom de code';
            }
          } else {
              $error = "";
        }

        require_once "views/modifyEntity/hideoutModify.view.php";
    }

    public function deleteHideoutInBdd($idHideout){
        if($this->hideoutManager->deleteHideoutInBdd($idHideout)){
            $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "La planque a bien été supprimée"         
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "La planque n'a pas été supprimé"         
            ];
        }
        header('Location: '. URL . "hideouts");
    }

    // fonctions requêtes Bdd hideout liées aux missions
    public function addhideoutsByMissionInBdd($idMission, $hideouts){
        $this->hideoutManager->addhideoutsByMissionInBdd($idMission, $hideouts);
    }

    public function modifyHideoutsByMissionInBdd($idMission, $hideouts){
        $this->hideoutManager->modifyHideoutsByMissionInBdd($idMission, $hideouts);
    }

    public function deleteHideoutsByMissionInBdd($idMission){
        $this->hideoutManager->deleteHideoutByMissionInBdd($idMission);
    }

}