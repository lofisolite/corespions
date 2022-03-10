<?php
session_start();

if(isset($_POST['deconnexion']) && !empty($_POST['deconnexion']) && $_POST['deconnexion'] === 'true'){
    session_destroy();
    header("location: home");
}

require_once "models/securite.php";
require_once "models/config.php";
require_once "controllers/MissionController.php";
require_once "controllers/SpyController.php";
require_once "controllers/TargetController.php";
require_once "controllers/ContactController.php";
require_once "controllers/HideoutController.php";
require_once "controllers/SpecialityController.php";
require_once "controllers/TypeOfMissionController.php";
require_once "controllers/AdminController.php";
require_once "controllers/BigControleur.php";

$missionController = new MissionController();
$spyController = new SpyController();
$targetController = new TargetController();
$contactController = new ContactController();
$hideoutController = new HideoutController();
$specialityController = new SpecialityController();
$typeOfMissionController = new TypeOfMissionController();
$adminController = new AdminController();
$bigController = new BigControleur();

try{
    if(empty($_GET['page'])){
        $bigController->homeDisplayMissions();
        
    } else {
        $getPage = explode("/", SecureData($_GET['page']));
        switch($getPage[0]){
            case "home" : 
                $bigController->homeDisplayMissions();
            break;
          //  case "test" : $bigController->test(3);
        // break;
            case "homeDisplayMission" :
                if(empty($getPage[1])){
                    throw new Exception("La page n'existe pas.");
                } else {
                     $bigController->homeDisplayMissionDetails($getPage[1]);
                }
            break;
            case "login" : $adminController->getPageLogin();
            break;
            case "admin" :
                if(verifyAccess()){
                    require_once "views/common/adminAccueil.view.php"; 
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accéder à la page d'administration.");
                }
            break;
            case "test" : $bigController->test();
            break;

            case "missions" : 
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        $bigController->displayMissions();
                    } else if($getPage[1] === "list") {
                        $bigController->displayMissionDetails($getPage[2]);
                    } else if($getPage[1] === "add") {
                        $bigController->validateMissionAdd();
                    } else if($getPage[1] === "modify") {
                        $bigController->validateMissionModify($getPage[2]);
                    } else if($getPage[1] === "delete") {
                        $bigController->deleteMissionInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des missions.");
                }
            break;

            case "spies" :
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        $spyController->displaySpies();
                    } else if($getPage[1] === "list"){
                        $bigController->displaySpyDetails($getPage[2]);
                    } else if($getPage[1] === "add") {
                        $bigController->validateSpyAdd();
                    } else if($getPage[1] === "modify") {
                        $bigController->validateSpyModify($getPage[2]);
                    } else if($getPage[1] === "delete") {
                        $bigController->deleteSpyInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des agents.");
                }
            break;

            case "targets" : 
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        $targetController->displayTargets();
                    } else if($getPage[1] === "list"){
                        $bigController->displayTargetDetails($getPage[2]);
                    } else if($getPage[1] === "add") {
                        $targetController->addTargetInBdd();
                    } else if($getPage[1] === "modify") {
                        $targetController->modifyTargetInBdd($getPage[2]);
                    } else if($getPage[1] === "delete") {
                        $targetController->deleteTargetInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des cibles.");
                }
            break;

            case "contacts" :
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        $contactController->displayContacts();
                    } else if($getPage[1] === "list"){
                        $bigController->displayContactDetails($getPage[2]);
                    } else if($getPage[1] === "add") {
                        $contactController->addContactInBdd();
                    } else if($getPage[1] === "modify") {
                        $contactController->modifyContactInBdd($getPage[2]);
                    } else if($getPage[1] === "delete") {
                        $contactController->deleteContactInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des contacts.");
                }
            break;
            case "hideouts" :
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        $hideoutController->displayHideouts();
                    } else if($getPage[1] === "list"){
                        $bigController->displayHideoutDetails($getPage[2]);
                    } else if($getPage[1] === "add") {
                        $hideoutController->addHideoutInBdd();
                    } else if($getPage[1] === "modify") {
                        $hideoutController->modifyHideoutInBdd($getPage[2]);
                    } else if($getPage[1] === "delete") {
                        $hideoutController->deleteHideoutInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des planques.");
                }
            break;

            case "specialities" :
                if(verifyAccess()){
                    if(empty($getPage[1])){
                        throw new Exception("La page n'existe pas.");
                    } else if($getPage[1] === "add"){
                        $specialityController->addSpecialityInBdd();
                    }  else if($getPage[1] === "modify"){
                        $specialityController->modifySpecialityInBdd($getPage[2]);
                    } else if($getPage[1] === "delete"){
                        $specialityController->deleteSpecialityInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des spécialitiés.");
                }
            break;

            case "typesOfMission" :
                if(verifyAccess()){
                    if(empty($getPage[1])){                        
                        throw new Exception("La page n'existe pas.");
                    } else if($getPage[1] === "add"){
                        $typeOfMissionController->addTypeOfMissionInBdd();
                    }  else if($getPage[1] === "modify"){
                        $typeOfMissionController->modifyTypeOfMissionInBdd($getPage[2]);
                    } else if($getPage[1] === "delete"){
                        $typeOfMissionController->deleteTypeOfMissionInBdd($getPage[2]);
                    } else {
                        throw new Exception("La page n'existe pas.");
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accèder à la page des types de missions.");
                }
            break;
            default : throw new Exception("La page n'existe pas"); 
        }
    }
}

catch(Exception $e){
     $Errormsg = $e->getMessage();
    require 'views/common/error.view.php';
}