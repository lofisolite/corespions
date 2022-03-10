<?php

require_once "models/manager/TargetManager.class.php";

class TargetController
{
    private $targetManager;

    public function __construct(){
        $this-> targetManager = new TargetManager();
        $this-> targetManager->loadTargets();
    }

    public function displayTargets(){
        $targets = $this->targetManager->getTargets();
        require_once "views/displayAll/targets.view.php";
    }

    public function giveTargets(){
        return $this->targetManager->getTargets();
    }

    public function giveTargetDetails($id){
        return $this->targetManager->getTargetById($id);
    }
    
    public function giveTargetsByMission($missionId){
        $this->targetManager->loadTargetsByMission($missionId);
        return $this->targetManager->getTargetsByMission();
    }

    public function giveTargetsIdByMission($missionId){
        $this->targetManager->loadTargetsByMission($missionId);
        $targetsByMission = $this->targetManager->getTargetsByMission();
        foreach($targetsByMission as $target){
            $targetIdByMission[] = $target->getId();
        }
        return $targetIdByMission;
    }
    
    // fonctions requêtes Bdd target
    public function addTargetInBdd(){
        $countryArray = giveArrayCountry();

        // validation du formulaire
        $error = '';
        if(isset($_POST['firstname']) && !empty($_POST['firstname']) 
            && isset($_POST['lastname']) && !empty($_POST['lastname'])
            && isset($_POST['codeName']) && !empty($_POST['codeName'])
            && isset($_POST['birthdate']) && !empty($_POST['birthdate'])
            && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])){

            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['firstname'])){
                if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['lastname'])){
                    if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){

                                $firstname = secureData($_POST['firstname']);
                                $lastname = secureData($_POST['lastname']);
                                $codeName = secureData($_POST['codeName']);
                                $birthdate = $_POST['birthdate'];
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);

                                // appel fonction ajout Bdd
                                $this->targetManager->addTargetInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);

                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "La cible a bien été ajoutée"         
                                ];

                                header('Location: '. URL . "targets");
                            
                    } else {
                        $error = 'Il y a des caractères non autorisés dans le nom de code';
                    }
                } else {
                    $error = 'Il y a des caractères non autorisés dans le nom';
                } 
            } else {
                $error = 'Il y a des caractères non autorisés dans le prénom';
            }
          } else {
              $error = "";
        }

        require_once "views/addEntity/targetAdd.view.php";
    }

    public function modifyTargetInBdd($idTarget){
               // Les propriétés de la mission à modifier
               $target = $this->giveTargetDetails($idTarget);
               $countryArray = giveArrayCountry();

       // validation du formulaire
       $error = '';
       if(isset($_POST['firstname']) && !empty($_POST['firstname']) 
           && isset($_POST['lastname']) && !empty($_POST['lastname'])
           && isset($_POST['codeName']) && !empty($_POST['codeName'])
           && isset($_POST['birthdate']) && !empty($_POST['birthdate'])
           && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])){

           if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['firstname'])){
               if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['lastname'])){
                   if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){

                               $firstname = secureData($_POST['firstname']);
                               $lastname = secureData($_POST['lastname']);
                               $codeName = secureData($_POST['codeName']);
                               $birthdate = $_POST['birthdate'];
                               $codeCountry = $_POST['codeCountry'];
                               $country = getCountryByCodeCountry($codeCountry, $countryArray);

                               // appel fonction ajout Bdd
                               $this->targetManager->modifyTargetInBdd($idTarget, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);

                               $_SESSION['alert'] = [
                                "type" => "success",
                                "msg" => "La cible a bien été modifiée"         
                            ];

                               header('Location: '. URL . "targets/list/" . $idTarget);
                   } else {
                       $error = 'Il y a des caractères non autorisés dans le nom de code';
                   }
               } else {
                   $error = 'Il y a des caractères non autorisés dans le nom';
               } 
           } else {
               $error = 'Il y a des caractères non autorisés dans le prénom';
           }
         } else {
             $error = "";
       }

       require_once "views/modifyEntity/targetModify.view.php";
    }

    public function deleteTargetInBdd($idTarget){
        if($this->targetManager->deleteTargetInBdd($idTarget)){
            $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "La cible a bien été supprimée"         
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "La cible ne peut pas être supprimé."         
            ];
        }

        header('Location: '. URL . "targets");
    }

    // fonctions requêtes Bdd target liées aux missions
    public function addTargetsByMissionInBdd($idMission, $targets){
        $this->targetManager->addTargetsByMissionInBdd($idMission, $targets);
    }

    public function modifyTargetsByMissionInBdd($idMission, $targets){
        $this->targetManager->modifyTargetsByMissionInBdd($idMission, $targets);
    }

    public function deleteTargetsByMissionInBdd($idMission){
        $this->targetManager->deleteTargetByMissionInBdd($idMission);
    }
}
