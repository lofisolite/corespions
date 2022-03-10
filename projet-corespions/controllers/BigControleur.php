<?php

require_once "controllers/MissionController.php";
require_once "controllers/SpyController.php";
require_once "controllers/ContactController.php";
require_once "controllers/TargetController.php";
require_once "controllers/HideoutController.php";
require_once "controllers/SpecialityController.php";
require_once "controllers/TypeOfMissionController.php";

class BigControleur{
    private $missionController;
    private $spyController;
    private $contactController;
    private $targetController;
    private $hideoutController;
    private $specialityController;
    private $typeOfMissionController;

    public function __construct(){
        $this->missionController = new MissionController();
        $this->spyController = new SpyController();
        $this->contactController = new ContactController();
        $this->targetController = new TargetController();
        $this->hideoutController = new HideoutController();
        $this->specialityController = new SpecialityController();
        $this->typeOfMissionController = new TypeOfMissionController();
    }

    public function test(){
        require_once "views/test.views.php";
    }

    // fonctions display entités
    public function homeDisplayMissions(){
        $missions = $this->missionController->giveMissions();
        $allTypeOfMissionByMission = $this->typeOfMissionController->giveAllTypeOfMissionByMission();
        require_once "views/displayAll/homeMissions.view.php";
    }
    
    public function displayMissions(){
        $missions = $this->missionController->giveMissions();
        $allTypeOfMissionByMission = $this->typeOfMissionController->giveAllTypeOfMissionByMission();
        require_once "views/displayAll/missions.view.php";
    }

    public function homeDisplayMissionDetails($id){
        $mission = $this->missionController->giveMissionDetails($id);
        $spies = $this->spyController->giveSpiesByMission($id);
        $contacts = $this->contactController->giveContactsByMission($id);
        $targets = $this->targetController->giveTargetsByMission($id);
        $hideouts = $this->hideoutController->givehideoutsByMission($id);
        $typeOfMission = $this->typeOfMissionController->giveTheTypeOfMissionByMission($id);
        $speciality = $this->specialityController->giveSpecialityByMission($id);
        require_once "views/displayDetail/homeMissionDetail.view.php";
    }

    public function displayMissionDetails($id){
        $mission = $this->missionController->giveMissionDetails($id);
        $spies = $this->spyController->giveSpiesByMission($id);
        $contacts = $this->contactController->giveContactsByMission($id);
        $targets = $this->targetController->giveTargetsByMission($id);
        $hideouts = $this->hideoutController->givehideoutsByMission($id);
        $typeOfMission = $this->typeOfMissionController->giveTheTypeOfMissionByMission($id);
        $speciality = $this->specialityController->giveSpecialityByMission($id);
        require_once "views/displayDetail/missionDetail.view.php";
    }

    public function displaySpyDetails($id){
        $spy = $this->spyController->giveSpyDetails($id);
        $specialities = $this->specialityController->giveSpecialitiesBySpy($id);
        $missions = $this->missionController->giveMissionsBySpy($id);
        require_once "views/displayDetail/spyDetail.view.php";
    }

    public function displayTargetDetails($id){
        $target = $this->targetController->givetargetDetails($id);
        $missions = $this->missionController->giveMissionsByTarget($id);
        require_once "views/displayDetail/targetDetail.view.php";
    }

    public function displayContactDetails($id){
        $contact = $this->contactController->giveContactDetails($id);
        $missions = $this->missionController->giveMissionsByContact($id);
        require_once "views/displayDetail/contactDetail.view.php";
    }

    public function displayHideoutDetails($id){
        $hideout = $this->hideoutController->giveHideoutDetails($id);
        $missions = $this->missionController->giveMissionsByHideout($id);
        require_once "views/displayDetail/hideoutDetail.view.php";
    }

    // fonction validation et CRUD mission
    public function validateMissionAdd(){
        $typesOfMission = $this->typeOfMissionController->giveTypesOfMission();
        $specialities = $this->specialityController->giveSpecialities();
        $spies = $this->spyController->giveSpies();
        $targets = $this->targetController->giveTargets();
        $contacts = $this->contactController->giveContacts();
        $hideouts = $this->hideoutController->givehideouts();
        $allSpecialitiesBySpy = $this->specialityController->giveAllSpecialitiesBySpies();

        $countryArray = giveArrayCountry();

        $error = '';
        if(isset($_POST['title']) && !empty($_POST['title']) 
            && isset($_POST['description']) && !empty($_POST['description'])
            && isset($_POST['codeName']) && !empty($_POST['codeName'])
            && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])
            && isset($_POST['missionType']) && !empty($_POST['missionType'])
            && isset($_POST['speciality']) && !empty($_POST['speciality'])
            && isset($_POST['startDate']) && !empty($_POST['startDate'])
            && isset($_POST['endDate']) && !empty($_POST['endDate'])){

            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['title'])){
                if(preg_match('/(^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:;]+$)/i', $_POST['description'])){
                    if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){

                        if(isset($_POST['status']) && !empty($_POST['status'])){
                            if(isset($_POST['optionSpy']) && !empty($_POST['optionSpy'])
                            && isset($_POST['optionTarget']) && !empty($_POST['optionTarget'])
                            && isset($_POST['optionContact']) && !empty($_POST['optionContact'])){

                                $title = secureData($_POST['title']);
                                $description = secureData($_POST['description']);
                                $status = $_POST['status'];
                                $codeName = secureData($_POST['codeName']);
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);
                                $missionType = $_POST['missionType'];
                                $speciality = $_POST['speciality'];
                                $spy = $_POST['optionSpy'];
                                $target = $_POST['optionTarget'];
                                $contact = $_POST['optionContact'];
                                if(isset($_POST['optionHideout'])){
                                    $hideout = $_POST['optionHideout'];
                                } else { 
                                    $hideout = false;
                                }
                                $startDate = $_POST['startDate'];
                                $endDate = $_POST['endDate'];

                                $this->addMission($title, $description, $status, $codeName, $codeCountry, $country, $missionType, $speciality, $spy, $target, $contact, $hideout, $startDate, $endDate);

                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "La mission a bien été ajoutée"         
                                ];

                                header('Location: '. URL . "missions");
                            } else{
                                 $error = 'il faut au moins un agent, une cible et un contact';
                            }
                        } else {
                           $error = 'La mission doit avoir un statut';
                        }
                    } else {
                        $error = 'Il y a des caractères non autorisés dans le nom de code';
                    }
                } else {
                    $error = 'Il y a des caractères non autorisés dans la description';
                } 
            } else {
                $error = 'Il y a des caractères non autorisés dans le titre';
            }
          } else {
              $error = "";
        }
        
        require_once "views/addEntity/missionAdd.view.php";
    }

    public function addMission($title, $description, $status,   $codeName, $codeCountry, $country, $typeOfMission, $speciality, $spy, $target, $contact, $hideout, $startDate, $endDate){

        $this->missionController->addMissionInBdd($title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate);

        $lastMissionId = $this->missionController->getLastIdMission();
        
        $this->spyController->addSpiesByMissionInBdd($lastMissionId, $spy);
        
        $this->targetController->addTargetsByMissionInBdd($lastMissionId, $target);

        $this->contactController->addContactsByMissionInBdd($lastMissionId, $contact);

        $this->typeOfMissionController->addTypeOfMissionByMissionInBdd($lastMissionId, $typeOfMission);

        $this->specialityController->addSpecialityByMissionInBdd($lastMissionId, $speciality);

        if(isset($hideout) && !empty($hideout)){
            $this->hideoutController->addhideoutsByMissionInBdd($lastMissionId, $hideout);
        }
    }

    public function validateMissionModify($idMission){
        // Les propriétés de la mission à modifier
        $mission = $this->missionController->giveMissionDetails($idMission);

        // Toutes les entités
        $allTypesOfMission = $this->typeOfMissionController->giveTypesOfMission();
        $allSpecialities = $this->specialityController->giveSpecialities();
        $allSpies = $this->spyController->giveSpies();
        $allTargets = $this->targetController->giveTargets();
        $allContacts = $this->contactController->giveContacts();
        $allHideouts = $this->hideoutController->givehideouts();
        $AllSpecialitiesBySpy = $this->specialityController->giveAllSpecialitiesBySpies();

        // Les entités liés à la mission
        $spiesId = $this->spyController->giveSpiesIdByMission($idMission);
        $targetsId = $this->targetController-> giveTargetsIdByMission($idMission);
        $contactsId = $this->contactController->giveContactsIdByMission($idMission);
        $hideoutsId = $this->hideoutController->giveHideoutsIdByMission($idMission);
        $typeOfMissionId = $this->typeOfMissionController->giveTheTypeOfMissionByMission($idMission);
        $specialityByMission = $this->specialityController->giveSpecialityByMission($idMission);
        
        $countryArray = giveArrayCountry();

        // validation du formulaire
        $error = '';
        if(isset($_POST['title']) && !empty($_POST['title']) 
            && isset($_POST['description']) && !empty($_POST['description'])
            && isset($_POST['codeName']) && !empty($_POST['codeName'])
            && isset($_POST['codeCountry']) && !empty($_POST['codeCountry'])
            && isset($_POST['missionType']) && !empty($_POST['missionType'])
            && isset($_POST['speciality']) && !empty($_POST['speciality'])
            && isset($_POST['startDate']) && !empty($_POST['startDate'])
            && isset($_POST['endDate']) && !empty($_POST['endDate'])){

            if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['title'])){
                if(preg_match('/(^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:;]+$)/i', $_POST['description'])){
                    if(preg_match('/(^[a-zéèàùâêîôûëçëïüÿ\s\'\-]+$)/i', $_POST['codeName'])){

                        if(isset($_POST['status']) && !empty($_POST['status'])){
                            if(isset($_POST['optionSpy']) && !empty($_POST['optionSpy'])
                            && isset($_POST['optionTarget']) && !empty($_POST['optionTarget'])
                            && isset($_POST['optionContact']) && !empty($_POST['optionContact'])){

                                $title = secureData($_POST['title']);
                                $description = secureData($_POST['description']);
                                $status = $_POST['status'];
                                $codeName = secureData($_POST['codeName']);
                                
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);
                                $missionType = $_POST['missionType'];
                                $speciality = $_POST['speciality'];
                                $spy = $_POST['optionSpy'];
                                $target = $_POST['optionTarget'];
                                $contact = $_POST['optionContact'];
                                if(isset($_POST['optionHideout'])){
                                    $hideout = $_POST['optionHideout'];
                                } else { 
                                    $hideout = " ";
                                }

                                $startDate = $_POST['startDate'];
                                $endDate = $_POST['endDate'];

                                $this->modifyMission($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $missionType, $speciality, $spy, $target, $contact, $hideout, $startDate, $endDate);

                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "La mission a bien été modifiée."         
                                ];

                                header('Location: '. URL . "missions/list/" . $idMission);
                            } else{
                                 $error = 'il faut au moins un agent, une cible et un contact';
                            }
                        } else {
                           $error = 'La mission doit avoir un statut';
                        }
                    } else {
                        $error = 'Il y a des caractères non autorisés dans le nom de code';
                    }
                } else {
                    $error = 'Il y a des caractères non autorisés dans la description';
                } 
            } else {
                $error = 'Il y a des caractères non autorisés dans le titre';
            }
          } else {
              $error = "";
        }

        require_once "views/modifyEntity/missionModify.view.php";
    }

    public function modifyMission($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $typeOfMission, $speciality, $spy, $target, $contact, $hideout, $startDate, $endDate){

            $this->missionController->modifyMissionInBdd($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate);
        
            $this->spyController->modifySpiesByMissionInBdd($idMission, $spy);
            
            $this->targetController->modifyTargetsByMissionInBdd($idMission, $target);
    
            $this->contactController->modifyContactsByMissionInBdd($idMission, $contact);

            $this->hideoutController->modifyHideoutsByMissionInBdd($idMission, $hideout);

            $this->typeOfMissionController->modifyTypeOfMissionByMissionInBdd($idMission, $typeOfMission);

            $this->specialityController->modifySpecialityByMissionInBdd($idMission, $speciality);
        }

    public function deleteMissionInBdd($idMission){
        $this->spyController->deleteSpiesByMissionInBdd($idMission);
        $this->targetController->deleteTargetsByMissionInBdd($idMission);
        $this->contactController->deleteContactsByMissionInBdd($idMission);
        $this->hideoutController->deleteHideoutsByMissionInBdd($idMission);
        $this->typeOfMissionController->deleteTypeOfMissionByMissionInBdd($idMission);
        $this->specialityController->deleteSpecialityByMissionInBdd($idMission);
        $this->missionController->deleteMission($idMission);

        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "La mission a bien été supprimée"         
        ];

        header('Location: '. URL . "missions");
    }

    // fonctions validate et CRUD spy
    public function validateSpyAdd(){
        $specialities = $this->specialityController->giveSpecialities();
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
                        if(isset($_POST['optionSpeciality']) && !empty($_POST['optionSpeciality'])){

                                $firstname = secureData($_POST['firstname']);
                                $lastname = secureData($_POST['lastname']);
                                $codeName = secureData($_POST['codeName']);
                                $birthdate = $_POST['birthdate'];
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);
                                $speciality = $_POST['optionSpeciality'];

                                // appel fonction ajout Bdd
                                $this->AddSpy($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country, $speciality);

                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "L'agent a bien été ajoutée"         
                                ];

                                header('Location: '. URL . "spies");
                            
                        } else {
                           $error = 'Une (ou plusieurs) spécialité doit être indiqué';
                        }
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

        require_once "views/addEntity/spyAdd.view.php";
    }

    public function AddSpy($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country, $speciality){

        $this->spyController->addSpyInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);

        $lastSpyId = $this->spyController->getLastIdSpy();

        $this->specialityController->addSpecialitiesBySpyInBdd($lastSpyId, $speciality);
    }

    public function validateSpyModify($idSpy){
            // Les propriétés de la mission à modifier
            $spy = $this->spyController->giveSpyDetails($idSpy);
            $specialitiesIdBySpy = $this->specialityController->giveSpecialitiesIdBySpy($idSpy);
            $specialities = $this->specialityController->giveSpecialities();
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
                        if(isset($_POST['optionSpeciality']) && !empty($_POST['optionSpeciality'])){

                                $firstname = secureData($_POST['firstname']);
                                $lastname = secureData($_POST['lastname']);
                                $codeName = secureData($_POST['codeName']);
                                $birthdate = $_POST['birthdate'];
                                $codeCountry = $_POST['codeCountry'];
                                $country = getCountryByCodeCountry($codeCountry, $countryArray);
                                $speciality = $_POST['optionSpeciality'];

                                // appel fonction ajout Bdd
                                $this->modifySpy($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country, $speciality);

                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "L'agent a bien été modifiée"         
                                ];

                                header('Location: '. URL . "spies/list/" . $idSpy);
                            
                        } else {
                           $error = 'Une (ou plusieurs) spécialité doit être indiqué';
                        }
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

        require_once "views/modifyEntity/spyModify.view.php";
    }

    public function modifySpy($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country, $speciality){

        $this->spyController->modifySpyInBdd($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country, $speciality);
    
        $this->specialityController->modifySpecialitiesBySpyInBdd($idSpy, $speciality);
    }

    public function deleteSpyInBdd($idSpy){
        $missions = $this->missionController->giveMissionsBySpy($idSpy);
        if($missions !== NULL){
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "L'agent ne peut pas être supprimé."         
            ];
        } else { 
            $this->specialityController->deleteSpecialitiesBySpyInBdd($idSpy);
            $this->spyController->deleteSpyInBdd($idSpy);

            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "L'agent a bien été supprimé."         
            ]; 
        }
        header('Location: '. URL . "spies");
    }
    
}

