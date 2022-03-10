<?php
ob_start();
?>

<br>
<h2>Ajout de planque</h2>

<div class="d-flex justify-content-center" >
    <form action="" method="POST" id="formHideout" class="form d-flex flex-column">
    <?php if(isset($error)) : ?>
            <span class="mb-3 error-msg"><?= $error ?></span>
        <?php endif ?>
        <div class="my-3">
            <p id="errorCodeName" class="mb-3 error-msg"></p>
            <label for="codeName" class="form-label">Nom de code</label>
            <input type="text" class="form-control" id="codeName" name="codeName" value="" minlength="2" maxlength="50" required>
        </div>
        <div class="my-3">
            <p id="errorAddress" class="mb-3 error-msg"></p>
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="address" id="address" value="" minlength="2" maxlength="150" required>
        </div>
        <div class="my-3">
             <label for="codeCountry" class="form-label">Pays</label>
            <select id="codeCountry" class="form-select" name="codeCountry" required>
            <?php foreach($countryArray as $clef => $valeur){  ?>
                <option value="<?= $clef ?>" 
                    <?php if(isset($_POST['codeCountry'])){ 
                        if($_POST['codeCountry'] === $clef){ 
                            echo "selected"; 
                        } 
                    }?>
                ><?= $valeur ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="my-3">
            <p id="errorType" class="mb-3 error-msg"></p>
            <label for="type" class="form-label">Type</label>
            <input type="text" value="" class="form-control" name="type" id="type" value="" minlength="2" maxlength="30" required>
        </div>
        <button type="submit" class="btn btn-info btn-lg align-self-center">Valider</Button>
    </form>
</div>

<a class="btn btn-info" href="<?= URL ?>hideouts">Retour aux planques</a>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Ajout planque";
$src = URL . "script/script-connexion.js";

require "views/common/template.php";