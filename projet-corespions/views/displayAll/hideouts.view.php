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
<h2>Les planques</h2>

<table class="table table-entity text-center">
    <tr>
        <th>N°</th>
        <th>Nom de code</th>
        <th class=" disp-none">pays</th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($hideouts); $i++) : ?>
    <tr>
        <td class="cell-border-right align-middle"><?= $hideouts[$i]->getId(); ?></td>
        <td class="cell-border-right align-middle"><?= $hideouts[$i]->getCodeName();?></td>
        <td class="cell-border-right align-middle disp-none"><?= $hideouts[$i]->getCountry(); ?></td>
        <td class="align-middle"><a class="btn btn-info" href="<?= URL ?>hideouts/list/<?= $hideouts[$i]->getId();?>">Détail</a></td>
    </tr>
    <?php endfor; ?>
</table>
<br>
<div class="d-flex flex-column">
    <a class="btn btn-success btn-lg align-self-center" href="<?= URL ?>hideouts/add">Ajouter une planque</a>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Planques Corespions";
$src ="";

require "views/common/template.php";
