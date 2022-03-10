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
<h2>Les spécialités</h2>

    <table class="table table-entity text-center">
        <tr class="">
            <th>Nom</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        
        <?php for($i=0; $i < count($specialities); $i++) : ?>
            <tr>
                <td class="cell-border-right align-middle">
                    <?= $specialities[$i]->getName(); ?></li>
                </td>
                <td class="cell-border-right align-middle">
                    <a href="<?= URL ?>specialities/modify/<?= $specialities[$i]->getId();?>" class="btn btn-success">Modifier</a>
                </td>
                <td class="">
                <?php if(!in_array($specialities[$i]->getId(), $specialitiesIdByMission) && !in_array($specialities[$i]->getId(), $specialitiesIdBySpy)){ ?>
                    <form method="POST" action="<?= URL ?>specialities/delete/<?= $specialities[$i]->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer le type de mission?');">
                    <button type="submit" class="btn btn-danger">supprimer</button>
                    </form>
                <?php }  else {
                    echo "Pas possible";
                     } ?>
                </td>
            </tr>
            <?php endfor; ?>
    </table>
<br>

<h3>Ajouter une spécialité</h3>
<div class="d-flex justify-content-center" >
    <form class="form form-spe d-flex flex-column"" action="" method="POST" id="formSpeciality">
    <?php if(isset($error)) : ?>
            <span class="mb-3 error-msg"><?= $error ?></span>
        <?php endif ?>
        <div class="my-3">
            <p id="errorName" class="mb-3 error-msg"></p>
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" minlength="2" maxlength="50" required>
        </div>
        <button type="submit" class="btn btn-info btn-lg align-self-center ">Valider</Button>
    </form>
</div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Ajout spécialité";
$src = URL . "script/script-connexion.js";;

require "views/common/template.php";
