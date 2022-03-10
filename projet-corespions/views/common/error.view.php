<?php
ob_start();
?>

<br>
<h2>Oups ! Il y a une erreur</h2>

<div class="d-flex flex-column align-items-center m-4">
    <br>
    <h4><?= $Errormsg ?></h4>
    <br>
    <a class="btn btn-info btn-lg" href="<?= URL ?>home">Retour à l'accueil</a>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Erreur Corespions";
$src = "";

require "views/common/template.php";