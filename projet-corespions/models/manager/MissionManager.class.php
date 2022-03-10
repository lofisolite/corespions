<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Mission.class.php";


Class MissionManager extends Bdd
{
  private $missions;
  private $missionsBySpy;
  private $missionsByTarget;
  private $missionsByContact;
  private $missionsByHideout;

  public function addMission($mission){
    $this->missions[] = $mission;
  }

  public function getMissions(){
    return $this->missions;
  }

  public function addMissionBySpy($mission){
    $this->missionsBySpy[] = $mission;
  }

  public function getMissionsBySpy(){
    return $this->missionsBySpy;
  }

  public function addMissionByTarget($mission){
    $this->missionsByTarget[] = $mission;
  }

  public function getMissionsByTarget(){
    return $this->missionsByTarget;
  }

  public function addMissionByContact($mission){
    $this->missionsByContact[] = $mission;
  }

  public function getMissionsByContact(){
    return $this->missionsByContact;
  }

  public function addMissionByHideout($mission){
    $this->missionsByHideout[] = $mission;
  }

  public function getMissionsByHideout(){
    return $this->missionsByHideout;
  }

  // fonctions chargement mission
  public function loadMissions(){
    $req = "SELECT * FROM mission";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    foreach($missions as $mission){
      $m = new Mission($mission['id'], $mission['title'], $mission['description'], $mission['code_name'], $mission['status'], $mission['code_country'], $mission['country'], $mission['start_date'], $mission['end_date']);
      $this->addMission($m);
    }
  }

  public function loadMissionsBySpy($idSpy){
    $req ="SELECT id_mission FROM spy_mission 
     Where :id = id_spy";
     $stmt = $this ->getBdd()->prepare($req);
     $stmt->bindValue(":id", $idSpy, PDO::PARAM_INT);
     $stmt->execute();
     $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
     $stmt->closeCursor();

    foreach($resultat as $value){
    $mission = $this->getMissionById($value);
    $this->addMissionBySpy($mission);
    }
}

public function loadMissionsByTarget($idTarget){
  $req ="SELECT id_mission FROM target_mission 
   Where :id = id_target";

   $stmt = $this ->getBdd()->prepare($req);
   $stmt->bindValue(":id", $idTarget, PDO::PARAM_INT);
   $stmt->execute();
   $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
   $stmt->closeCursor();

  foreach($resultat as $value){
  $mission = $this->getMissionById($value);
  $this->addMissionByTarget($mission);
  }
}

public function loadMissionsByContact($idContact){
  $req ="SELECT id_mission FROM contact_mission 
   Where :id = id_contact";
   $stmt = $this ->getBdd()->prepare($req);
   $stmt->bindValue(":id", $idContact, PDO::PARAM_INT);
   $stmt->execute();
   $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
   $stmt->closeCursor();

  foreach($resultat as $value){
  $mission = $this->getMissionById($value);
  $this->addMissionByContact($mission);
  }
}

public function loadMissionsByHideout($idHideout){
  $req ="SELECT id_mission FROM hideout_mission 
   Where :id = id_hideout";
   $stmt = $this ->getBdd()->prepare($req);
   $stmt->bindValue(":id", $idHideout, PDO::PARAM_INT);
   $stmt->execute();
   $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
   $stmt->closeCursor();

  foreach($resultat as $value){
  $mission = $this->getMissionById($value);
  $this->addMissionByHideout($mission);
  }
}

  public function getMissionById($id){
      for($i=0; $i < count($this->missions); $i++){
          if($this->missions[$i]->getId() === $id){
              return $this->missions[$i];
          }
      }
    throw new Exception("La mission n'existe pas  tralala");
  }

  public function getLastIdMission(){
    $missions = $this->getMissions();
    $lastMission = end($missions);
    $lastMissionId = $lastMission->getId();
    return $lastMissionId;
  }

  // fonctions requêtes Bdd mission
  public function addMissionInBdd($title, $description, $status, $codeName, $codeCountry, $country,  $startDate, $endDate){
      $req ="
      INSERT INTO mission(title, description, status, code_name, code_country, country, start_date, end_date) 
      VALUES(:title, :description, :status, :code_name, :code_country, :country, :start_date, :end_date)
      "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":title", $title, PDO::PARAM_STR);
      $stmt->bindValue(":description", $description, PDO::PARAM_STR);
      $stmt->bindValue(":status", $status, PDO::PARAM_STR);
      $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
      $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
      $stmt->bindValue(":country", $country, PDO::PARAM_STR);
      $stmt->bindValue(":start_date", $startDate, PDO::PARAM_STR);
      $stmt->bindValue(":end_date", $endDate, PDO::PARAM_STR);
      $result = $stmt->execute();
      $stmt->closeCursor();

      if($result){
        $mission = new Mission($this->getBdd()->lastInsertId(), $title, $description, $codeName, $status, $codeCountry, $country, $startDate, $endDate);
        $this->addMission($mission);
      } else {
        return die();
      }
  }

  public function modifyMissionInBdd($idMission, $title, $description, $status, $codeName, $codeCountry, $country, $startDate, $endDate){
    $req ="
      UPDATE mission 
      SET title = :title, 
      description = :description, 
      status = :status, 
      code_name = :code_name, 
      code_country = :code_country, 
      country = :country,
      start_date = :start_date, 
      end_date = :end_date
      WHERE id = :id_mission"; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $stmt->bindValue(":title", $title, PDO::PARAM_STR);
      $stmt->bindValue(":description", $description, PDO::PARAM_STR);
      $stmt->bindValue(":status", $status, PDO::PARAM_STR);
      $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
      $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
      $stmt->bindValue(":country", $country, PDO::PARAM_STR);
      $stmt->bindValue(":start_date", $startDate, PDO::PARAM_STR);
      $stmt->bindValue(":end_date", $endDate, PDO::PARAM_STR);
      $resultat = $stmt->execute();
      $stmt->closeCursor();
  }

  public function deleteMissionInBdd($idMission){
    if($this->getMissionById($idMission) instanceof Mission){
    $req ="
    DELETE FROM mission WHERE id = :id_mission
      "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->closeCursor(); 
    }
  }
}
