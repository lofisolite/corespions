<?php

require_once "models/manager/AdminManager.class.php";

class AdminController
{
    private $adminManager;

    public function __construct(){
        $this-> adminManager = new AdminManager();
        $this-> adminManager ->loadAdmins();
    }

    public function getPageLogin(){
        if(verifyAccess()){
            header("location: admin");
        } 
                $alert = "";
                if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password'])){  
                    $login = SecureData($_POST['login']);
                    $password = secureData($_POST['password']); 
                if($this->adminManager->isAdminConnexionValid($login, $password)){
                        $_SESSION['access'] = 'admin';
                        genereCookieSession();
                        header("location: admin");
                    } else {
                        $alert = "mot de passe ou login non valide.";
                    } 
                }
       require_once "views/common/connexion.view.php";
    }

}