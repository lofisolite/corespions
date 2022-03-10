<?php
ob_start();

if(!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
    <?= $_SESSION['alert']['msg'] ?>
    </div>
<?php unset($_SESSION['alert']);
endif;
?>

<br>
<h2>Les cibles</h2>
<table class="table table-entity text-center">
    <tr>
        <th>N°</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($targets); $i++) : ?>
    <tr>
        <td class="cell-border-right align-middle"><?= $targets[$i]->getId(); ?></td>
        <td class="cell-border-right align-middle"><?= $targets[$i]->getFirstname(); ?></td>
        <td class="cell-border-right align-middle"><?= $targets[$i]->getLastname(); ?></td>
        <td class="align-middle"><a class="btn btn-info" href="<?= URL ?>targets/list/<?= $targets[$i]->getId();?>">Détail</a></td>
    </tr>
    <?php endfor; ?>
</table>

<br>
<div class="d-flex flex-column">
    <a class="btn btn-success btn-lg align-self-center" href="<?= URL ?>targets/add">Ajouter une cible</a>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Cibles Corespions";
$src ="";

require "views/common/template.php";
