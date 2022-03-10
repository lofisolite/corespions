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
<h2>Les missions</h2>
<table class="table table-mission text-center">
    <tr>
        <th>N°</th>
        <th>Titre</th>
        <th class="disp-none">Type de mission</th>
        <th>Statut</th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($missions); $i++) : ?>
    <tr>
        <td class="cell-border-right align-middle"><?= $missions[$i]->getid(); ?></td>
        <td class="cell-border-right align-middle"><?= $missions[$i]->getTitle(); ?></td>
        <td class="cell-border-right align-middle disp-none">
            <?php foreach($allTypeOfMissionByMission as $typeOfMissionByMission){
                if($missions[$i]->getId() === $typeOfMissionByMission['id_mission']){
                    echo $typeOfMissionByMission['name'];
                }
            }
            ?>
            </td>
        <td class="cell-border-right  align-middle"><?= $missions[$i]->getStatus(); ?></td>
        <td class="align-middle"><a class="btn btn-info" href="<?= URL ?>missions/list/<?= $missions[$i]->getId();?>">Détail</a></td>
    </tr>

    <?php endfor; ?>
</table>
<br>
<div class="d-flex flex-column">
    <a class="btn btn-success btn-lg align-self-center" href="<?= URL ?>missions/add">Ajouter une mission</a>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Missions Corespions";
$src ="";

require "views/common/template.php";