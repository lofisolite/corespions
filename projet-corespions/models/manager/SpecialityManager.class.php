<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Speciality.class.php";


Class SpecialityManager extends Bdd
{
  private $specialities;
  private $specialityByMission;
  private $specialitiesBySpy;

  public function addSpeciality($speciality){
    $this->specialities[] = $speciality;
  }

  public function getSpecialities(){
    return $this->specialities;
  }

  public function addSpecialityByMission($speciality){
    $this->specialityByMission = $speciality;
  }

  public function getSpecialityByMission(){
      return $this->specialityByMission;
  }

  public function addSpecialityBySpy($speciality){
      $this->specialitiesBySpy[] = $speciality;
  }

  public function getSpecialitiesBySpy(){
      return $this->specialitiesBySpy;
  }

  // fonctions chargement speciality
  public function loadSpecialities(){
    $req = "SELECT * FROM speciality";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $specialities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
 
    foreach($specialities as $speciality){
      $s = new Speciality($speciality['id'], $speciality['name']);
      $this->addSpeciality($s);
    }
  }

  public function loadSpecialityByMission($idMission){
    $req ="
    SELECT s.id
    FROM mission_speciality ms, speciality s
    WHERE :id_mission = ms.id_mission
    AND s.id  = ms.id_speciality
    ";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
     $stmt->execute();
     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
     $stmt->closeCursor();

    // return $resultat;
    foreach($resultat as $value){
     $speciality = $this->getSpecialityById($value);
      $this->addSpecialityByMission($speciality);
    }
  }    
  
  public function loadAllSpecialitiesIdByMission(){
      $req ="
        SELECT id_speciality FROM mission_speciality 
         ";
         $stmt = $this ->getBdd()->prepare($req);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
         $stmt->closeCursor();

        return $result;
    }

    public function loadAllSpecialitiesBySpy(){
      $req ="
      SELECT ss.id_spy, s.name
      FROM spy_speciality ss, speciality s
      WHERE s.id = ss.id_speciality
      ";
      $stmt = $this ->getBdd()->prepare($req);
      $stmt->execute();
      $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $resultat;
    }

  public function loadSpecialitiesBySpy($idSpy){
        $req ="
        SELECT id_speciality
        FROM spy_speciality
         WHERE :id = id_spy
         ";
         $stmt = $this ->getBdd()->prepare($req);
         $stmt->bindValue(":id", $idSpy, PDO::PARAM_INT);
         $stmt->execute();
         $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
         $stmt->closeCursor();

        foreach($resultat as $value){
          $speciality = $this->getSpecialityById($value);
          $this->addSpecialityBySpy($speciality);
        }
    }

    public function loadSpecialitiesIdBySpy($idSpy){
      $req ="
      SELECT id_speciality
      FROM spy_speciality
       WHERE :id = id_spy
       ";
       $stmt = $this ->getBdd()->prepare($req);
       $stmt->bindValue(":id", $idSpy, PDO::PARAM_INT);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
       $stmt->closeCursor();

       return $result;
    }

    public function loadAllSpecialitiesIdBySpy(){
      $req ="
        SELECT id_speciality FROM spy_speciality 
         ";
         $stmt = $this ->getBdd()->prepare($req);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
         $stmt->closeCursor();

        return $result;
    }

    public function getSpecialityById($id){
        for($i=0; $i < count($this->specialities); $i++){
            if($this->specialities[$i]->getId() === $id){
                return $this->specialities[$i];
            }
        }
        die();
      //throw new Exception("la spécialité n'existe pas");
    }

    // requêtes Bdd spécialité
    public function addSpecialityInBdd($name){
      $req ="
      INSERT INTO speciality(name) VALUES(:name)
      "; 
      $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":name", $name, PDO::PARAM_STR);
      $stmt->execute();
      $stmt->closeCursor();
    }

    
    public function modifySpecialityInBdd($specialityId, $nameSpeciality){
      $req ="
      UPDATE speciality
      SET name = :name
      WHERE id = :id_speciality";
  
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_speciality", $specialityId, PDO::PARAM_INT);
      $stmt->bindValue(":name", $nameSpeciality, PDO::PARAM_STR);
      $stmt->execute();
      $stmt->closeCursor();
    }

    public function deleteSpecialityInBdd($specialityId){
      if($this->getSpecialityById($specialityId) instanceof Speciality){
        $req ="
        DELETE FROM speciality WHERE id = :id_speciality
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_speciality", $specialityId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
    
        return $result;
      }
    }

    // requêtes Bdd spécialité liées aux missions
    public function addSpecialityByMissionInBdd($idMission, $specialityId){
        $req ="
        INSERT INTO mission_speciality(id_mission, id_speciality) VALUES(:id_mission, :id_speciality)
        "; 
        $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $stmt->bindValue(":id_speciality", $specialityId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
  }

  public function modifySpecialityByMissionInBdd($idMission, $specialityId){
        $req ="
        UPDATE mission_speciality
        SET id_speciality = :id_speciality
        WHERE id_mission = :id_mission
        "; 
        $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $stmt->bindValue(":id_speciality", $specialityId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
  }

  public function deleteSpecialityByMissionInBdd($idMission){
    $req = "
    DELETE FROM mission_speciality WHERE id_mission = :id_mission
    ";
    $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();
  }

  // requêtes Bdd spécialité liées aux agents
    public function addSpecialitiesBySpyInBdd($idSpy, $specialities){
      foreach($specialities as $nameSpecialities){
        $req ="INSERT INTO spy_speciality(id_speciality, id_spy) VALUES(:id_speciality, :id_spy)
        "; 
        $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_speciality", $nameSpecialities, PDO::PARAM_INT);
        $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
  }

  public function modifySpecialitiesBySpyInBdd($idSpy, $specialities){
    $req1 = "DELETE FROM spy_speciality WHERE id_spy = :id_spy";
      $stmt = $this ->getBdd()->prepare($req1);
      $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();

      if($state === true){
        foreach($specialities as $idSpecialities){
          $req ="
          INSERT INTO spy_speciality(id_speciality, id_spy) 
          VALUES(:id_speciality, :id_spy)
          "; 
          $stmt = $this ->getBdd()->prepare($req);
          $stmt->bindValue(":id_speciality", $idSpecialities, PDO::PARAM_INT);
          $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
          $stmt->execute();
          $stmt->closeCursor();
        }
      }
  }

  public function deleteSpecialitiesBySpyInBdd($idSpy){
    $req = "
    DELETE FROM spy_speciality WHERE id_spy = :id_spy
    ";
    $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();
  }
}
