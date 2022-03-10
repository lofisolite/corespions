<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Spy.class.php";


Class SpyManager extends Bdd
{
  private $spies;
  private $spiesByMission;

  public function addSpy($spy){
    $this->spies[] = $spy;
  }

  public function getSpies(){
    return $this->spies;
  }

  public function addSpyByMission($spy){
      $this->spiesByMission[] = $spy;
  }

  public function getSpiesByMission(){
      return $this->spiesByMission;
  }

  // fonctions chargement spy
  public function loadSpies(){
    $req = "SELECT * FROM spy";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $spies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    foreach($spies as $spy){
      $s = new Spy($spy['id'], $spy['code_name'], $spy['firstname'], $spy['lastname'], $spy['birthdate'], $spy['code_country'], $spy['country']);
      $this->addSpy($s);
    }
  }

  public function loadSpiesByMission($idMission){
        $req ="SELECT id_spy FROM spy_mission 
         Where :id = id_mission";
         $stmt = $this ->getBdd()->prepare($req);
         $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
         $stmt->execute();
         $resultat = $stmt->fetchAll(PDO::FETCH_COLUMN);
         $stmt->closeCursor();

        foreach($resultat as $value){
        $spy = $this->getSpieById($value);
        $this->addSpyByMission($spy);
        }
    }

    public function loadSpiesIdByMission($idMission){
      $req ="SELECT id_spy FROM spy_mission 
       Where :id = id_mission";
       $stmt = $this ->getBdd()->prepare($req);
       $stmt->bindValue(":id", $idMission, PDO::PARAM_INT);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
       $stmt->closeCursor();

      return $result;
  }

    public function getSpieById($id){
        for($i=0; $i < count($this->spies); $i++){
            if($this->spies[$i]->getId() === $id){
                return $this->spies[$i];
            }
        }
      throw new Exception("L'agent n'existe pas");
    }

    // fonctions requêtes Bdd spy
    public function addSpyInBdd($firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
      $req ="
      INSERT INTO spy(code_name, firstname, lastname, birthdate, code_country, country) VALUES(:code_name, :firstname, :lastname, :birthdate, :code_country, :country)
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
        $spy = new Spy($this->getBdd()->lastInsertId(), $codeName, $firstname, $lastname, $birthdate, $codeCountry, $country);
        $this->addSpy($spy);
      }
    }

    public function getLastIdSpy(){
      $spies = $this->getSpies();
      $lastspy = end($spies);
      $lastSpyId = $lastspy->getId();
      return $lastSpyId;
    }

    public function modifySpyInBdd($idSpy, $firstname, $lastname, $codeName, $birthdate, $codeCountry, $country){
      $req ="
      UPDATE spy 
      SET code_name = :code_name, 
      firstname = :firstname,
      lastname = :lastname,
      birthdate = :birthdate,
      code_country = :code_country, 
      country = :country
      WHERE id = :id_spy";

      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
      $stmt->bindValue(":code_name", $codeName, PDO::PARAM_STR);
      $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
      $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
      $stmt->bindValue(":birthdate", $birthdate, PDO::PARAM_STR);
      $stmt->bindValue(":code_country", $codeCountry, PDO::PARAM_STR);
      $stmt->bindValue(":country", $country, PDO::PARAM_STR);
      $resultat = $stmt->execute();
      $stmt->closeCursor();
    }

    public function deleteSpyInBdd($idSpy){
      if($this->getSpieById($idSpy)){
        $req ="
        DELETE FROM spy WHERE id = :id_spy
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
      }
    }

    // fonctions requêtes Bdd spy liées aux missions
    public function addSpiesByMissionInBdd($idMission, $spies){
        foreach($spies as $idSpy){
          $req ="INSERT INTO spy_mission(id_mission, id_spy) VALUES(:id_mission, :id_spy)"; 
          $stmt = $this ->getBdd()->prepare($req);
          $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
          $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
          $stmt->execute();
          $stmt->closeCursor();
        }
    }

    public function modifySpiesByMissionInBdd($idMission, $spies){
      $req1 = "DELETE FROM spy_mission WHERE id_mission = :id_mission";
      $stmt = $this ->getBdd()->prepare($req1);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $state = $stmt->execute();
        $stmt->closeCursor();

        if($state === true){
            foreach($spies as $idSpy){
              $req2 ="INSERT INTO spy_mission(id_mission, id_spy) VALUES(:id_mission, :id_spy)
              "; 
              $stmt = $this ->getBdd()->prepare($req2);
              $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
              $stmt->bindValue(":id_spy", $idSpy, PDO::PARAM_INT);
              $stmt->execute();
              $stmt->closeCursor();
            } 
        } else {
          
        }
    }

    public function deleteSpyByMissionInBdd($idMission){
      $req = "
      DELETE FROM spy_mission WHERE id_mission = :id_mission
      ";
      $stmt = $this ->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission", $idMission, PDO::PARAM_INT);
        $state = $stmt->execute();
        $stmt->closeCursor();
    }
}
