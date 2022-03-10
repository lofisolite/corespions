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
<h2><?= $hideout->getCodeName()?></h2>
<br>

    <table class="table table-detail table-grey text-center">
        <tr>
            <th class="th-cell-left">nom de code</th>
            <td><?= $hideout->getCodeName(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Adresse</th>
            <td><?= $hideout->getAddress(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Pays</th>
            <td><?= $hideout->getCountry(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Type</th>
            <td><?= $hideout->getType(); ?></td>
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
    <a class="btn btn-info  align-self-center" href="<?= URL ?>hideouts">Retour aux planques</a>
    <div class="d-flex flex-column">   
    <a class="btn btn-success m-1" href="<?= URL ?>hideouts/modify/<?= $hideout->getId(); ?>">Modifier la planque</a>

    <?php if(!isset($missions)){ ?>
        <form method="POST" action="<?= URL ?>hideouts/delete/<?= $hideout->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer la planque?');">
        <button type="submit" class="btn btn-danger m-1">supprimer la planque</button>
    <?php } ?>
    </div>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "planque Corespions";
$src ="";

require_once "views/common/template.php";


