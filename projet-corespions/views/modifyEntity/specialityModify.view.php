<?php
ob_start();
?>

<br>
<h2>Modification de la spécialité</h2>

<div class="d-flex justify-content-center" >
    <form action="" method="POST" id="formTypeOfMission" class="form d-flex flex-column">
    <?php if(isset($error)) : ?>
            <span class="mb-3 error-msg"><?= $error ?></span>
        <?php endif ?>
        <div class="my-3">
        <p id="errorName" class="mb-3 error-msg"></p>
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? $speciality->getName(); ?>" minlength="2" maxlength="50" required>
        </div>
        <button type="submit" class="btn btn-info btn-lg align-self-center">Valider</Button>
    </form>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleh2 = "modifier la spécialité";
$titleHead = "modification spécialité";
$src = URL . "script/script-connexion.js";;

require "views/common/template.php";
