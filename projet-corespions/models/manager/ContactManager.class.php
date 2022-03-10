<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Contact.class.php";


Class ContactManager extends Bdd
{
  private $contacts;
  private $contactsByMission;

  public function addContact($contact){
    $this->contacts[] = $contact;
  }

  public function getContacts(){
    return $this->contacts;
  }

  public function addContactByMission($contact){
      $this->contactsByMission[] = $contact;
  }

  public function getContactsByMission(){
      return $this->contactsByMission;
  }
  
  // fonctions chargement contact
  public function loadContacts(){
    $req = "SELECT * FROM contact";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach($contacts as $contact){
      $c = new Contact($contact['id'], $contact['code_name'], $contact['firstname'], $contact['lastname'], $contact['birthdate'], $contact['code_country'], $contact['country']);
      $this->addContact($c);
    }
  }

  public function loadContactsByMission($idMission){
    $req ="SELECT id_contact FROM contact_mission 
     Where :id = id_mission";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
     $stmt->execute();
     $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
     $stmt->closeCursor();

    foreach($resultat as $value){
    $contact = $this->getContactById($value);
    $this->addcontactByMission($contact);
    }
}

  public function getContactById($id){
      for($i=0; $i < count($this->contacts); $i++){
          if($this->contacts[$i]->getId() === $id){
              return $this->contacts[$i];
          }
      }
    throw new Exception("Le contact n'existe pas");
  }

  // fonctions requetes bdd contact
  public function addContactInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
    $req ="
    INSERT INTO contact(code_name, firstname, lastname, birthdate, code_country, country) VALUES(:code_name, :firstname, :lastname, :birthdate, :code_country, :country)
    "; 
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
    $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $stmt->bindValue(":birthdate", $birthdate, PDO::PARAM_STR);
    $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $resultat = $stmt->execute();
    $stmt->closeCursor();

    if($resultat === true){
      $contact = new Contact($this->getBdd()->lastInsertId(), $codeName, $firstname, $lastname, $birthdate, $codeCountry, $country);
      $this->addContact($contact);
    } else {
      die();
    }
  }

  public function modifyContactInBdd($idContact, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
    $req ="
    UPDATE contact
    SET code_name = :code_name, 
    firstname = :firstname,
    lastname = :lastname,
    birthdate = :birthdate,
    code_country = :code_country, 
    country = :country
    WHERE id = :id_contact";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_contact", $idContact, PDO::PARAM_INT);
    $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
    $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $stmt->bindValue(":birthdate", $birthdate, PDO::PARAM_STR);
    $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $resultat = $stmt->execute();
    $stmt->closeCursor();
  }

  public function deleteContactInBdd($idContact){
    if($this->getContactById($idContact) instanceof Contact){
      $req ="
      DELETE FROM contact WHERE id = :id_contact
      "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_contact", $idContact, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();

      return $result;
    }
  }

  // fonctions requete Bdd contact liées aux missions
  public function addContactsByMissionInBdd($idMission, $contacts){
    foreach($contacts as $idContact){
      $req ="INSERT INTO contact_mission(id_mission, id_contact) VALUES(:id_mission, :id_contact)"; 
      $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $stmt->bindValue(":id_contact", $idContact, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->closeCursor();
    }
  }

  public function modifyContactsByMissionInBdd($idMission, $contacts){
    $req1 = "DELETE FROM contact_mission WHERE id_mission = :id_mission";
    $stmt = $this ->getBdd()->prepare($req1);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();

      if($state === true){
          foreach($contacts as $idContact){
            $req2 ="INSERT INTO contact_mission (id_mission, id_contact) VALUES(:id_mission, :id_contact)"; 
            $stmt = $this ->getBdd()->prepare($req2);
            $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
            $stmt->bindValue(":id_contact", $idContact, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
          } 
      } else {

      }
  }

  public function deleteContactByMissionInBdd($idMission){
    $req = "
    DELETE FROM contact_mission WHERE id_mission = :id_mission
    ";
    $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();
  }
}
