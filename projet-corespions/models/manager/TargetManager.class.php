<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Target.class.php";


Class TargetManager extends Bdd
{
  private $targets;
  private $targetsByMission;

  public function addTarget($target){
    $this->targets[] = $target;
  }

  public function getTargets(){
    return $this->targets;
  }

  public function addTargetByMission($target){
      $this->targetsByMission[] = $target;
  }

  public function getTargetsByMission(){
      return $this->targetsByMission;
  }

  // fonctions chargement target
  public function loadTargets(){
    $req = "SELECT * FROM target";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $targets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach($targets as $target){
      $t = new target($target['id'], $target['code_name'], $target['firstname'], $target['lastname'], $target['birthdate'], $target['code_country'], $target['country']);
      $this->addTarget($t);
    }
  }

  public function loadtargetsByMission($idMission){
    $req ="SELECT id_target FROM target_mission 
     Where :id = id_mission";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
     $stmt->execute();
     $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
     $stmt->closeCursor();

    foreach($resultat as $value){
    $target = $this->getTargetById($value);
    $this->addTargetByMission($target);
    }
}

  public function getTargetById($id){
      for($i=0; $i < count($this->targets); $i++){
          if($this->targets[$i]->getId() === $id){
              return $this->targets[$i];
          }
      }
    throw new Exception("La cible n'existe pas");
  }

  // fonctions requetes Bdd target
  public function addTargetInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
    $req ="
    INSERT INTO target(code_name, firstname, lastname, birthdate, code_country, country) VALUES(:code_name, :firstname, :lastname, :birthdate, :code_country, :country)
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
      $target = new Target($this->getBdd()->lastInsertId(), $codeName, $firstname, $lastname, $birthdate, $codeCountry, $country);
      $this->addTarget($target);
    }
  }

  public function modifyTargetInBdd($idTarget, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
    $req ="
    UPDATE target 
    SET code_name = :code_name, 
    firstname = :firstname,
    lastname = :lastname,
    birthdate = :birthdate,
    code_country = :code_country, 
    country = :country
    WHERE id = :id_target";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_target", $idTarget, PDO::PARAM_INT);
    $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
    $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
    $stmt->bindValue(":birthdate", $birthdate, PDO::PARAM_STR);
    $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function deleteTargetInBdd($idTarget){
    if($this->getTargetById($idTarget) instanceof Target){
      $req ="
      DELETE FROM target WHERE id = :id_target
      "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_target", $idTarget, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();

      return $result;
    }
}

    // fonctions requêtes Bdd target liées aux missions
    public function addTargetsByMissionInBdd($idMission, $targets){
      foreach($targets as $idTarget){
        $req ="INSERT INTO target_mission (id_mission, id_target) VALUES(:id_mission, :id_target)"; 
        $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $stmt->bindValue(":id_target", $idTarget, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
      }
    }
  
    public function modifyTargetsByMissionInBdd($idMission, $targets){
      $req1 = "DELETE FROM target_mission WHERE id_mission = :id_mission";
      $stmt = $this ->getBdd()->prepare($req1);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $state = $stmt->execute();
        $stmt->closeCursor();
  
        if($state === true){
            foreach($targets as $idTarget){
              $req2 ="INSERT INTO target_mission (id_mission, id_target) VALUES(:id_mission, :id_target)"; 
              $stmt = $this ->getBdd()->prepare($req2);
              $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
              $stmt->bindValue(":id_target", $idTarget, PDO::PARAM_INT);
              $stmt->execute();
              $stmt->closeCursor();
            }
        }
    }
  
    public function deleteTargetByMissionInBdd($idMission){
      $req = "
      DELETE FROM target_mission WHERE id_mission = :id_mission
      ";
      $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $state = $stmt->execute();
        $stmt->closeCursor();
    }
}
