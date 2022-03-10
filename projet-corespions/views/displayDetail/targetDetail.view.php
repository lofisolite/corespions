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
<h2><?= $target->getFirstName() . " " . $target->getLastname();?></h2>
<br>

    <table class="table table-detail table-grey text-center">
        <tr>
            <th class="th-cell-left">Prénom</th>
            <td><?= $target->getFirstname(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nom</th>
            <td><?= $target->getLastname(); ?></td>
        </tr>        
        <tr>
            <th class="th-cell-left">Nom de code</th>
            <td><?= $target->getCodeName(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Date de naissance</th>
            <td class="align-middle"><?= formatDate($target->getBirthdate()); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nationalité</th>
            <td class="align-middle"><?= $target->getCountry(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Missions</th>
            <td>
                <ul>
            <?php if(isset($missions)){
                for($i=0; $i < count($missions); $i++) : ?>
                <li><?= $missions[$i]->getTitle();?></li>
            <?php endfor;
            } else { ?>
            <?php echo "Pas de mission";
            } ?>
                </ul>
        </td>
        </tr>
    </table>

<br>
<div class="d-flex justify-content-between">
    <a class="btn btn-info  align-self-center" href="<?= URL ?>targets">Retour aux cibles</a>
    <div class="d-flex flex-column">   
    <a class="btn btn-success m-1" href="<?= URL ?>targets/modify/<?= $target->getId(); ?>">Modifier la cible</a>

    <?php if(!isset($missions)){ ?>
    <form method="POST" action="<?= URL ?>targets/delete/<?= $target->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer la cible?');">
    <button type="submit" class="btn btn-danger m-1">supprimer la cible</button>
    <?php } ?> 
    </div>
</div>
<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Cibles Corespions";
$src ="";

require_once "views/common/template.php";


