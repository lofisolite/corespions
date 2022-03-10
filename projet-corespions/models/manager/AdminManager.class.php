<?php
require_once "models/Bdd.class.php";
require_once "models/entity/Admin.class.php";


Class AdminManager extends Bdd
{
  private $admins;

  public function addAdmin($admin){
    $this->admins[] = $admin;
  }

  public function getAdmins(){
    return $this->admins;
  }

  // fonction chargement speciality
  public function loadAdmins(){
    $req = "SELECT * FROM admin";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    foreach($admins as $admin){
      $a = new Admin($admin['id'], $admin['login'], $admin['password']);
      $this->addAdmin($a);
    }
  }

    public function getAdminByLogin($login){
      for($i=0; $i < count($this->admins);$i++){
          if($this->admins[$i]->getLogin() === $login){
              return $this->admins[$i];
          }
      }
      throw new Exception("Erreur pour récupérer l'admin par login.");
    }

    public function isAdminConnexionValid($login, $password){
      $admin = $this->getAdminByLogin($login);
      $bddPassword = $admin->getPassword();
      return password_verify($password, $bddPassword);
    }
}
