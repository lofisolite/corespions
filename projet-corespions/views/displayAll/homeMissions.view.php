<?php
ob_start();
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
            ?></td>

        <td class="cell-border-right align-middle"><?= $missions[$i]->getStatus(); ?></td>
        <td class="align-middle"><a class="btn btn-info" href="<?= URL ?>homeDisplayMission/<?= $missions[$i]->getId();?>">Détail</a></td>
        <?php endfor; ?>
    </tr>
</table>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Missions Corespions";
$src ="";

require "views/common/template.php";