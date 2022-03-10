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
<h2><?= $titleh2 = $contact->getFirstname() . " " . $contact->getLastname(); ?></h2>
<br>

    <table class="table table-detail table-grey text-center">
        <tr>
            <th class="th-cell-left">Prénom</th>
            <td class="align-middle"><?= $contact->getFirstname(); ?></td>
        </tr>
        <tr>
            <th  class="th-cell-left">Nom</th>
            <td class="align-middle"><?= $contact->getLastname(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nom de code</th>
            <td class="align-middle"><?= $contact->getCodeName(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Date de naissance</th>
            <td class="align-middle"><?= formatDate($contact->getBirthdate()); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Nationalité</th>
            <td class="align-middle"><?= $contact->getCountry(); ?></td>
        </tr>
        <tr>
            <th class="th-cell-left">Missions</th>
            <td class="align-middle">
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
    <a class="btn btn-info  align-self-center" href="<?= URL ?>contacts">Retour aux contacts</a>
    <div class="d-flex flex-column">

    <a class="btn btn-success m-1" href="<?= URL ?>contacts/modify/<?= $contact->getId(); ?>">Modifier le contact</a>

    <?php if(!isset($missions)){ ?>
    <form method="POST" action="<?= URL ?>contacts/delete/<?= $contact->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer le contact?');">
    <button type="submit" class="btn btn-danger m-1">supprimer le contact</button>
    </form>
    <?php } ?>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "contacts Corespions";
$src ="";

require_once "views/common/template.php";


