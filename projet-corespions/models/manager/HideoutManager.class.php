<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Hideout.class.php";


Class HideoutManager extends Bdd
{
  private $hideouts;
  private $hideoutsByMission;

  public function addHideout($hideout){
    $this->hideouts[] = $hideout;
  }

  public function getHideouts(){
    return $this->hideouts;
  }

  public function addHideoutByMission($hideout){
      $this->hideoutsByMission[] = $hideout;
  }

  public function getHideoutsByMission(){
      return $this->hideoutsByMission;
  }
  
  // fonctions chargement hideout
  public function loadHideouts(){
    $req = "SELECT * FROM hideout";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $hideouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    foreach($hideouts as $hideout){
      $h = new Hideout($hideout['id'], $hideout['code_name'], $hideout['address'], $hideout['code_country'], $hideout['country'], $hideout['type']);
      $this->addHideout($h);
    }
  }

  public function loadHideoutsByMission($idMission){
        $req ="SELECT id_hideout FROM hideout_mission 
         Where :id = id_mission";
         $stmt = $this ->getBdd()->prepare($req);
         $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
         $stmt->execute();
         $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
         $stmt->closeCursor();
         
        foreach($resultat as $value){
        $hideout = $this->getHideoutsById($value);
        $this->addHideoutByMission($hideout);
        }
        return $resultat;
    }

    public function loadHideoutsIdByMission($idMission){
      $req ="SELECT id_hideout FROM hideout_mission 
       Where :id = id_mission";
       $stmt = $this ->getBdd()->prepare($req);
       $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
       $stmt->execute();
       $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
       $stmt->closeCursor();
       
      return $resultat;
  }

    public function getHideoutsById($id){
        for($i=0; $i < count($this->hideouts); $i++){
            if($this->hideouts[$i]->getId() === $id){
                return $this->hideouts[$i];
            }
        }
      throw new Exception("La planque n'existe pas");
    }

  // fonctions requêtes Bdd hideout
  public function addHideoutInBdd($codeName, $address, $codeCountry, $country, $type){
    $req ="
    INSERT INTO hideout(code_name, address, code_country, country, type) VALUES(:code_name, :address, :code_country, :country, :type)
    "; 
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
    $stmt->bindValue(":address", $address, PDO::PARAM_STR);
    $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $stmt->bindValue(":type", $type, PDO::PARAM_STR);
    $resultat = $stmt->execute();
    $stmt->closeCursor();

    if($resultat === true){
      $hideout = new Hideout($this->getBdd()->lastInsertId(), $codeName, $address, $codeCountry, $country, $type);
      $this->addHideout($hideout);
    }
  }

  public function modifyHideoutInBdd($idHideout, $codeName, $address, $codeCountry, $country, $type){
    $req ="
    UPDATE hideout 
    SET code_name = :code_name, 
    address = :address,
    code_country = :code_country, 
    country = :country,
    type = :type
    WHERE id = :id_hideout";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_hideout", $idHideout, PDO::PARAM_INT);
    $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
    $stmt->bindValue(":address", $address, PDO::PARAM_STR);
    $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $stmt->bindValue(":type", $type, PDO::PARAM_STR);
    $resultat = $stmt->execute();
    $stmt->closeCursor();
  }

  public function deleteHideoutInBdd($idHideout){
    if($this->getHideoutsById($idHideout) instanceof Hideout){
      $req ="
      DELETE FROM hideout WHERE id = :id_hideout
      "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_hideout", $idHideout, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();

      return $result;
    }
  }

  // fonctions requêtes Bdd hideout liées aux missions
  public function addhideoutsByMissionInBdd($idMission, $hideouts){
    foreach($hideouts as $idHideout){
      $req ="INSERT INTO hideout_mission (id_mission, id_hideout) VALUES(:id_mission, :id_hideout)"; 
      $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $stmt->bindValue(":id_hideout", $idHideout, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->closeCursor();
    }
}

  public function modifyHideoutsByMissionInBdd($idMission, $hideouts){
    $req1 = "DELETE FROM hideout_mission WHERE id_mission = :id_mission";
    $stmt = $this ->getBdd()->prepare($req1);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $state = $stmt->execute();
      $stmt->closeCursor();

      if($state === true && $hideouts !== " "){
          foreach($hideouts as $idHideout){
            $req2 ="INSERT INTO hideout_mission (id_mission, id_hideout) VALUES(:id_mission, :id_hideout)"; 
            $stmt = $this ->getBdd()->prepare($req2);
            $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
            $stmt->bindValue(":id_hideout", $idHideout, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
          }
      } 
}

  public function deleteHideoutByMissionInBdd($idMission){
    $req = "
    DELETE FROM hideout_mission WHERE id_mission = :id_mission
    ";
    $stmt = $this ->getBdd()->prepare($req);
      $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->closeCursor();
  }
}
