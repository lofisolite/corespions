<?php
ob_start();
?>
<br>
<h2>Ajout de Mission</h2>

<div class="d-flex justify-content-center" >
    <form action="" method="POST" id="formMission" class="form d-flex flex-column">
        <?php if(isset($error)) : ?>
            <span class="mb-3 error-msg"><?= $error ?></span>
        <?php endif ?>
        <div class="my-3">
            <p id="errorTitle" class="mb-3 error-msg"></p>
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $_POST['title'] ?? '' ?>" minlength="2" maxlength="120" required>
        </div>

        <div class="my-3">
            <p id="errorDescription" class="mb-3 error-msg"></p>
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control"  id="description" name="description" value="" cols="30" rows="6" min="2" max="1000" required><?= $_POST['description'] ?? '' ?></textarea>
        </div>

        <div class="my-3">
            <p>Statut</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status1" value="en préparation"
                    <?php if(isset($_POST['status']) && $_POST['status'] === "en préparation"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?> 
                >
                <label class="form-check-label" for="status1">En préparation</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status2" value="en cours"
                    <?php if(isset($_POST['status']) && $_POST['status'] === "en cours"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?> 
                >
                <label class="form-check-label" for="status2">En cours</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status3" value="terminé"
                    <?php if(isset($_POST['status']) && $_POST['status'] === "terminé"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?> 
                >
                <label class="form-check-label" for="status3">Terminé</label>
            </div>
            <div class="form-check">
                <input class="form-check-input"  type="radio" name="status" id="status4" value="échec"
                    <?php if(isset($_POST['status']) && $_POST['status'] === "échec"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?>
                >
                <label class="form-check-label" for="status4">Echéc</label>
            </div>
        </div>

        <div class="my-3">
            <p id="errorCodeName" class="mb-3 error-msg"></p>
            <label for="codeName" class="form-label">Nom de code</label>
            <input type="text" class="form-control" id="codeName" name="codeName" value="<?= $_POST['codeName'] ?? '' ?>" min="2" max="50" required>
        </div>

        <div class="my-3">
            <label for="codeCountry" class="form-label">Pays</label>
            <select id="codeCountry" class="form-select" name="codeCountry" required>
            <?php foreach($countryArray as $clef => $valeur){  ?>
                <option value="<?= $clef ?>" 
                    <?php if(isset($_POST['codeCountry'])){ 
                        if($_POST['codeCountry'] === $clef){ 
                            echo "selected"; 
                        }
                    }?>
                ><?= $valeur ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="my-3">
        <label for="missionType" class="form-label">Type de mission</label>
        <select class="form-select" id="missionType" name="missionType" aria-label="Default select example" required>
            <?php for($i=0; $i < count($typesOfMission); $i++) : ?>
            <option value="<?= $typesOfMission[$i]->getId(); ?>" 
                <?php if(isset($_POST['missionType'])){ 
                        if($_POST['missionType'] === $typesOfMission[$i]->getId()){ 
                            echo "selected"; 
                        } 
                }?>
            ><?= $typesOfMission[$i]->getName(); ?></option>
             <?php endfor; ?>
        </select>
        </div>

        <div class="my-3">
        <label for="speciality" class="form-label">Spécialité requise</label>
        <select class="form-select" id="speciality" name="speciality" aria-label="Default select example" required>
            <?php for($i=0; $i < count($specialities); $i++) : ?>
            <option value="<?= $specialities[$i]->getId(); ?>"
                <?php if(isset($_POST['missionType'])){ 
                        if($_POST['speciality'] === $specialities[$i]->getId()){ 
                            echo "selected"; 
                        } 
                } ?>
            ><?= $specialities[$i]->getName(); ?></option>
             <?php endfor; ?>
        </select>
        </div>

        <div class="my-3">
            <p class="explication-msg" class="mb-3">Au moins un agent avec la spécialité requise.</p>
            <p class="form-label">Agent(s)</p>
            <div class="form-check">
            <?php for($i=0; $i < count($spies); $i++){
            $idSpy = $spies[$i]->getId();?>
                <?php if(isset($_POST['optionSpy'])){ ?>
                        <input class="my-2" type="checkbox" 
                        id="<?= "spy" . $spies[$i]->getId(); ?>" 
                        name="optionSpy[]" 
                        value="<?= $spies[$i]->getId(); ?>" 
                            <?php if(in_array($spies[$i]->getId(), $_POST['optionSpy'])){ 
                                 echo "checked"; 
                            } else { 
                                echo " ";
                            } ?>
                        >
                            <label for="<?= "spy" . $spies[$i]->getId(); ?>">
                            <?= $spies[$i]->getFirstname() . " ". $spies[$i]->getLastName() . " - "  . $spies[$i]->getCountry() ?> <?= displaySpecialitiesBySpyInMissionForm($idSpy, $allSpecialitiesBySpy) ?>
                            </label>
                            <br>
                <?php }  else {?>
                        <input class="my-2" type="checkbox" 
                        id="<?= "spy" . $spies[$i]->getId(); ?>" 
                        name="optionSpy[]" 
                        value="<?= $spies[$i]->getId(); ?>">
                        <label for="<?= "spy" . $spies[$i]->getId(); ?>">
                        <?= $spies[$i]->getFirstname() . " ". $spies[$i]->getLastName() . " - "  . $spies[$i]->getCountry() ?> <?= displaySpecialitiesBySpyInMissionForm($idSpy, $allSpecialitiesBySpy) ?>
                        </label>
                        <br>
                <?php }?>
            <?php } ?>
            </div>
        </div>

        <div class="my-3">
            <p class="explication-msg" class="mb-3">Nationalité différente des agents.</p>
            <p class="form-label">Cible(s)</p>
            <div class="form-check">
            <?php for($i=0; $i < count($targets); $i++){ ?>
                <?php if(isset($_POST['optionTarget'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "target" . $targets[$i]->getId(); ?>" 
                    name="optionTarget[]" 
                    value="<?= $targets[$i]->getId(); ?>" 
                        <?php if(in_array($spies[$i]->getId(), $_POST['optionTarget'])){ 
                            echo "checked"; 
                        } else { 
                            echo " ";
                        } ?>
                    >
                    <label for="<?= "target" . $targets[$i]->getId(); ?>">
                    <?= $targets[$i]->getFirstname() . " ". $targets[$i]->getLastName() . " - " . $targets[$i]->getCountry();?>
                    </label>
                    <br>
                <?php }  else {?>  
                    <input class="my-2" type="checkbox" 
                    id="<?= "target" . $targets[$i]->getId(); ?>" 
                    name="optionTarget[]" 
                    value="<?= $targets[$i]->getId(); ?>">
                    <label for="<?= "target" . $targets[$i]->getId(); ?>">
                    <?= $targets[$i]->getFirstname() . " ". $targets[$i]->getLastName() . " - " . $targets[$i]->getCountry();?>
                </label>
                <br>
                <?php }?>
            <?php } ?>
            </div>
        </div>

        <div class="my-3">
            <p class="explication-msg" class="mb-3">Doit avoir la nationalité du pays de la mission.</p>
            <p class="form-label">Contact(s)</p>
            <div class="form-check">
            <?php for($i=0; $i < count($contacts); $i++){ ?>
                <?php if(isset($_POST['optionContact'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "contact" . $contacts[$i]->getId(); ?>" 
                    name="optionContact[]" 
                    value="<?= $contacts[$i]->getId(); ?>" 
                        <?php if(in_array($spies[$i]->getId(), $_POST['optionContact'])){ 
                            echo "checked"; 
                        } else { 
                            echo " ";
                        }?>
                    >
                    <label for="<?= "contact" . $contacts[$i]->getId(); ?>">
                    <?= $contacts[$i]->getFirstname() . " ". $contacts[$i]->getLastName() . " - " . $contacts[$i]->getCountry();?>
                    </label>
                    <br>
                <?php }  else { ?> 
                    <input class="my-2" type="checkbox" 
                    id="<?= "contact" . $contacts[$i]->getId(); ?>" 
                    name="optionContact[]" 
                    value="<?= $contacts[$i]->getId(); ?>"
                    >
                    <label for="<?= "contact" . $contacts[$i]->getId(); ?>">
                    <?= $contacts[$i]->getFirstname() . " ". $contacts[$i]->getLastName() . " - " . $contacts[$i]->getCountry();?>
                    </label>
                    <br>
                <?php }?>
            <?php } ?>
            </div>
        </div>

        <div class="my-3">
            <p class="explication-msg" class="mb-3">La planque (s'il y en a une) doit être dans le pays de la mission.</p>
            <p class="form-label">Planque(s)</p>
            <div class="form-check">
            <?php for($i=0; $i < count($hideouts); $i++){ ?>
                <?php if(isset($_POST['optionHideout'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "hideout" . $hideouts[$i]->getId(); ?>" 
                    name="optionHideout[]" 
                    value="<?= $hideouts[$i]->getId(); ?>"
                        <?php if(in_array($spies[$i]->getId(), $_POST['optionHideout'])){ 
                            echo "checked"; 
                        } else { 
                                echo " ";
                        }?>
                    >
                    <label for="<?= "hideout" . $hideouts[$i]->getId(); ?>">
                    <?= $hideouts[$i]->getCodeName() . " - ". $hideouts[$i]->getCountry() . " - " . $hideouts[$i]->getType();?>
                    </label>
                    <br>
                <?php }  else {?> 
                    <input class="my-2" type="checkbox" 
                    id="<?= "hideout" . $hideouts[$i]->getId(); ?>" 
                    name="optionHideout[]" 
                    value="<?= $hideouts[$i]->getId(); ?>"
                    >
                    <label for="<?= "hideout" . $hideouts[$i]->getId(); ?>">
                    <?= $hideouts[$i]->getCodeName() . " - ". $hideouts[$i]->getCountry() . " - " . $hideouts[$i]->getType();?>
                    </label>
                    <br>
                <?php } ?>
            <?php } ?>
            </div>
        </div>

        <div class="my-3">
            <label for="startDate" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="startDate" name="startDate" value="<?= $_POST['title'] ?? '' ?>" required>
        </div>

        <div class="my-3">
            <label for="endDate" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="endDate" name="endDate" value="<?= $_POST['title'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-info btn-lg align-self-center">Valider</Button>
    </form>
</div>

<a class="btn btn-info" href="<?= URL ?>missions">Retour aux missions</a>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Ajout mission";
$src = URL . "script/script-connexion.js";

require "views/common/template.php";