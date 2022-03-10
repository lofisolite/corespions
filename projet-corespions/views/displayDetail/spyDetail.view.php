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
<h2><?= $titleh2 = $spy->getFirstname() . " " . $spy->getLastname();?></h2>
<br>

    <table class="table table-detail table-grey text-center">
        <tr>
            <th class="th-cell-left">Prénom</th>
            <td><?= $spy->getFirstname(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nom</th>
            <td><?= $spy->getLastname(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nom de code</th>
            <td><?= $spy->getCodeName(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Date de naissance</th>
            <td class="align-middle"><?= formatDate($spy->getBirthdate()); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nationalité</th>
            <td class="align-middle"><?= $spy->getCountry(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Spécialités</th>
            <td>
                <ul>
                <?php for($i=0; $i < count($specialities); $i++): ?>
                    <li><?= $specialities[$i]->getName();?></li>
                <?php endfor; ?>
                </ul>
        </td>
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
    <a class="btn btn-info  align-self-center" href="<?= URL ?>spies">Retour aux agents</a>
    <div class="d-flex flex-column">   
    <a class="btn btn-success align-self-center" href="<?= URL ?>spies/modify/<?= $spy->getId(); ?>">modifier l'agent</a>
    
    <?php if(!isset($missions)){ ?>
        <form method="POST" action="<?= URL ?>spies/delete/<?= $spy->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer l\'agent?');">
        <button type="submit" class="btn btn-danger m-1">supprimer l'agent</button>
    <?php } ?>
    </div>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Agents Corespions";
$src ="";

require_once "views/common/template.php";


