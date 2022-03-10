<?php
ob_start();
?>

<a class="btn btn-info btn-lg" href="<?= URL ?>home">Retour aux missions</a>

<?php
$contentBtn = ob_get_clean();
ob_start();
?>
<h2><?= $mission->getTitle(); ?></h2>
<br>
<div class="d-flex flex-column align-items-center">
    <p>Mission du <span><?= formatDate($mission->getStartDate()); ?></span> au <span><?= formatDate($mission->getEndDate());?></span>
    <br>
    <div class="text-container">
        <p class="text-center"><?=$mission->getDescription();?></p>
    </div>
    <br>
    <p class="">statut : <?=$mission->getstatus();?></p>
</div>
<br>

<table class="table table-detail table-grey text-center">
    <tr>
        <th class="th th-cell-left">Nom de code</th>
        <td class="td-cell-right"><?= $mission->getCodeName(); ?></td>
    </tr>
    <tr>
        <th class="th th-cell-left">Pays</th>
        <td class="td-cell-right"><?= $mission->getCountry(); ?></td>
    </tr>
    <tr>
        <th class="th th-cell-left">Type de mission</th>
        <td class="td-cell-right"><?= $typeOfMission->getName(); ?></td>
    </tr>
    <tr>
        <th class="th th-cell-left">Spécialité requise</th>        
        <td class="td-cell-right"><?= $speciality->getName(); ?></td>
    </tr>
    <tr rowspan=<?=count($spies)?> class="">
        <th class="th th-cell-left">Agent</th>
        <td class="td-cell-right">
            <ul>
            <?php for($i=0; $i < count($spies); $i++) : ?>
                <li><?= $spies[$i]->getFirstname();?>  <?= $spies[$i]->getLastname();?></li>
            <?php endfor; ?>
            </ul>
        </td>
    </tr>
    <tr>
        <th class="th th-cell-left">Cible</th>
        <td class="td-cell-right">
            <ul>
            <?php for($i=0; $i < count($targets); $i++) : ?>
                <li><?= $targets[$i]->getFirstname();?>  <?= $targets[$i]->getLastname();?></li>
            <?php endfor; ?>
            </ul>
        </td>
    </tr>
    <tr>
        <th class="th th-cell-left">Contact</th>
        <td class="td-cell-right">
            <ul>
            <?php for($i=0; $i < count($contacts); $i++) : ?>
                <li><?= $contacts[$i]->getFirstname();?>  <?= $contacts[$i]->getLastname();?></li>
            <?php endfor; ?>
            </ul>
        </td>
    </tr>
    <tr>
        <th class="th th-cell-left">Planque</th>        
        <td class="td-cell-right">
            <ul>
            <?php if(isset($hideouts)){
                for($i=0; $i < count($hideouts); $i++) : ?>
                <li><?= $hideouts[$i]->getAddress();?> - <?= $hideouts[$i]->getCountry();?></li>
            <?php    endfor;
            } else { ?>
            <?php echo "Pas de planque";
            } ?>
            </ul>
        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();

$preContent = $contentBtn;
$titleHead = "Missions Corespions";
$src= "";
require_once "views/common/template.php";


