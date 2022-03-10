<?php

require_once "models/manager/ContactManager.class.php";

class ContactController
{
    private $contactManager;

    public function __construct(){
        $this-> contactManager = new ContactManager();
        $this-> contactManager->loadContacts();
    }

    public function displayContacts(){
        $contacts = $this->contactManager->getContacts();
        require_once "views/displayAll/contacts.view.php";
    }

    public function giveContactDetails($contactId){
        return $this->contactManager->getContactById($contactId);
    }
    
    public function giveContactsByMission($missionId){
        $this->contactManager->loadContactsByMission($missionId);
        return $this->contactManager->getContactsByMission();
    }

    public function giveContactsIdByMission($missionId){
        $this->contactManager->loadContactsByMission($missionId);
        $contactsByMission = $this->contactManager->getContactsByMission();
        foreach($contactsByMission as $contact){
            $contactsIdByMission[] = $contact->getId();
        }
        return $contactsIdByMission;
    }

    public function giveContacts(){
        return $this->contactManager->getContacts();
    }
    // fonctions requêtes Bdd contact liées aux missions
    public function addContactsByMissionInBdd($idMission, $contacts){
        $this->contactManager->addContactsByMissionInBdd($idMission, $contacts);
    }

    public function modifyContactsByMissionInBdd($idMission, $contacts){
        $this->contactManager->modifyContactsByMissionInBdd($idMission, $contacts);
    }

    public function deleteContactsByMissionInBdd($idMission){
        $this->contactManager->deleteContactByMissionInBdd($idMission);
    }

    //fonctions requête Bdd contact
    public function addContactInBdd(){
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
                                $this->contactManager->addContactInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);
                                
                                $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "Le contact a bien été ajouté"         
                                ];
                        

                                header('Location: '. URL . "contacts");
                            
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

        require_once "views/addEntity/contactAdd.view.php";
    }
    
    public function modifyContactInBdd($idContact){
             // Les propriétés de la mission à modifier
             $contact = $this->giveContactDetails($idContact);
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
                                 $this->contactManager->modifyContactInBdd($idContact, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country);
                                
                                 $_SESSION['alert'] = [
                                    "type" => "success",
                                    "msg" => "Le contact a bien été modifié"         
                                ];
 
                                 header('Location: '. URL . "contacts/list/" . $idContact);
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
 
         require_once "views/modifyEntity/contactModify.view.php";
    }

    public function deleteContactInBdd($idContact){
        if($this->contactManager->deleteContactInBdd($idContact)){
            $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Le contact a bien été supprimé"         
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "Le contact ne peut pas être supprimé"         
            ];
        }

        header('Location: '. URL . "contacts");
    }
}

