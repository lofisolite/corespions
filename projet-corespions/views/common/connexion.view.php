<?php
ob_start();
?>

<br>
<h2>Connexion</h2>

<div class="d-flex justify-content-center" >
    <form action="" method="POST" class="form d-flex flex-column" id="formConnexion">
        <p id="errorMsg" class="mb-3 error-msg"><?= $alert ?></p>
        <div class="mb-3">
            <p id="errorLogin" class="mb-3 error-msg"></p>
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login" value="" minlength="2" maxlength="30" required>
        </div>
        <div class="mb-3">
            <p id="errorPassword" class="mb-3 error-msg"></p>
            <label for="password" class="form-label">Mot de passe</label>
            <div class="container-password">
                <input type="password" class="form-control" id="password" name="password" value="" required>
                <img id="eye" src="images/notvisible.png" alt="">
            </div>
        </div>
        <button type="submit" class="btn btn-info align-self-center">Valider</Button>
    </form>
</div>

<?php

$content = ob_get_clean();

$preContent = "";
$titleHead = "Connexion Corespions";
$src = URL . "script/script-connexion.js";

require "views/common/template.php";