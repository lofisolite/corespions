<?php
require_once "models/Bdd.class.php";
require_once "models/entity/TypeOfMission.class.php";


Class TypeOfMissionManager extends Bdd
{
  private $typesOfMission;
  private $typeByMission;

  public function addTypeOfMission($typeOfMission){
    $this->typesOfMission[] = $typeOfMission;
  }

  public function getTypesOfMission(){
    return $this->typesOfMission;
  }

  public function addTypeOfMissionByMission($typeOfMission){
    $this->typeByMission = $typeOfMission;
  }

  public function getTypeOfMissionByMission(){
      return $this->typeByMission;
  }

  // fonction chargement de type de mission
  public function loadTypesOfMission(){
    $req = "SELECT * FROM type_of_mission";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    foreach($types as $type){
      $t = new TypeOfMission($type['id'], $type['name']);
      $this->addTypeOfMission($t);
    }
  }

  public function loadTypeOfMissionByMission($idMission){
    $req ="
    SELECT t.id 
    FROM mission_type_of_mission mt, type_of_mission t
    WHERE :id_mission = mt.id_mission
    AND t.id  = mt.id_type_of_mission
    ";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
     $stmt->execute();
     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
     $stmt->closeCursor();

    // return $resultat;
    foreach($resultat as $value){
     $type = $this->getTypeOfMissionById($value);
      $this->addTypeOfMissionByMission($type);
    }
  }

  public function loadTypeOfMissionIdByMission(){
    $req ="
      SELECT id_type_of_mission FROM mission_type_of_mission 
       ";
       $stmt = $this ->getBdd()->prepare($req);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
       $stmt->closeCursor();

      return $result;
  }

  public function loadAllTypesOfMissionByMission(){
    $req ="
    SELECT mt.id_mission, t.name 
    FROM mission_type_of_mission mt, type_of_mission t
    WHERE t.id = mt.id_type_of_mission
    ";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->execute();
     $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
     $stmt->closeCursor();

    return $resultat;
  }

  public function getTypeOfMissionById($id){
    for($i=0; $i < count($this->typesOfMission); $i++){
        if($this->typesOfMission[$i]->getId() === $id){
            return $this->typesOfMission[$i];
        }
    }
  throw new Exception("Le type de mission n'existe pas");
}

    // requêtes Bdd type de mission
    public function addTypeOfMissionInBdd($name){
      $req ="
      INSERT INTO type_of_mission(name) VALUES(:name)
      "; 
      $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":name", $name, PDO::PARAM_STR);
      $stmt->execute();
      $stmt->closeCursor();
    }

    public function modifyTypeOfMissionInBdd($typeOfMissionId, $name){
      $req ="
      UPDATE type_of_mission
      SET name = :name
      WHERE id = :id_type_of_mission";
  
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_type_of_mission", $typeOfMissionId, PDO::PARAM_INT);
      $stmt->bindValue(":name", $name, PDO::PARAM_STR);
      $resultat = $stmt->execute();
      $stmt->closeCursor();
    }

    public function deleteTypeOfMissionInBdd($typeOfMissionId){
      if($this->getTypeOfMissionById($typeOfMissionId) instanceof TypeOfMission){
        $req ="
        DELETE FROM type_of_mission WHERE id = :id_type_of_mission
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_type_of_mission", $typeOfMissionId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
    
        return $result;
      }
    }

    // requêtes Bdd type de mission liées aux missions
    public function addTypeOfMissionByMissionInBdd($idMission, $typeOfMission){
        $req ="
        INSERT INTO mission_type_of_mission(id_mission, id_type_of_mission) VALUES(:id_mission, :id_type_of_mission)
        "; 
        $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $stmt->bindValue(":id_type_of_mission", $typeOfMission, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
  }

  public function modifyTypeOfMissionByMissionInBdd($idMission, $typeOfMissionId){
    $req ="
        UPDATE mission_type_of_mission
        SET id_type_of_mission = :id_type_of_mission
        WHERE id_mission = :id_mission
      "; 
    $stmt = $this ->getBdd()->prepare($req);
    $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
    $stmt->bindValue(":id_type_of_mission", $typeOfMissionId, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public function deleteTypeOfMissionByMissionInBdd($idMission){
    $req = "
    DELETE FROM mission_type_of_mission WHERE id_mission = :id_mission
    ";
    $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();
  }
    
}

