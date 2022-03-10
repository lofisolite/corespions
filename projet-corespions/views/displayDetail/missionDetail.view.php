<?php
ob_start();

if(!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
    <?= $_SESSION['alert']['msg'] ?>
    </div>
<?php unset($_SESSION['alert']);
endif;
?>

<h2><?= $mission->getTitle(); ?></h2>
<br>
<div class="d-flex flex-column align-items-center">
    <p class="">Mission du <span><?= formatDate($mission->getStartDate()); ?></span> au <span><?= formatDate($mission->getEndDate());?></span>
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
    <tr>
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

<br>
<div class="d-flex justify-content-between">
    <a class="btn btn-info  align-self-center" href="<?= URL ?>missions">Retour aux missions</a>
    <div class="d-flex flex-column">   
    <a class="btn btn-success align-self-center" href="<?= URL ?>missions/modify/<?= $mission->getId(); ?>">modifier la mission</a>
    <form method="POST" action="<?= URL ?>missions/delete/<?= $mission->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer la mission?');">
    <button type="submit" class="btn btn-danger m-1">supprimer la mission</button>
    </div>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Missions Corespions";
$src= "";
require_once "views/common/template.php";


