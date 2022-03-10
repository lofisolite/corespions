<?php
ob_start();
?>

<br>
<h2>Modification de la mission</h2>

<div class="d-flex justify-content-center" >
    <form action="" method="POST" id="formMission" class="form d-flex flex-column">
        <?php if(isset($error)) : ?>
            <span class="mb-3 error-msg"><?= $error ?></span>
        <?php endif ?>
        <div class="my-3">
            <p id="errorTitle" class="mb-3 error-msg"></p>
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $_POST['title'] ?? $mission->getTitle(); ?>" minlength="2" maxlength="120" required>
        </div>

        <div class="my-3">
            <p id="errorDescription" class="mb-3 error-msg"></p>
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control"  id="description" name="description" value="" cols="30" rows="6" min="2" max="1000" required><?= $_POST['description'] ?? $mission->getDescription(); ?></textarea>
        </div>

        <div class="my-3">
            <p>Statut</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status1" value="en préparation"
                    <?php if($mission->getStatus() === "en préparation"){ 
                        echo "checked" ;
                    } else { 
                            echo " ";
                    } ?>
                >
                <label class="form-check-label" for="status1">En préparation</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status2" value="en cours"
                    <?php if($mission->getStatus() === "en cours"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?> 
                >
                <label class="form-check-label" for="status2">En cours</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status3" value="terminé"
                    <?php if($mission->getStatus() === "terminé"){ 
                        echo "checked" ;
                    } else { 
                        echo " ";
                    } ?> 
                >
                <label class="form-check-label" for="status3">Terminé</label>
            </div>
            <div class="form-check">
                <input class="form-check-input"  type="radio" name="status" id="status4" value="échec"
                    <?php if($mission->getStatus() === "échec"){ 
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
            <input type="text" class="form-control" id="codeName" name="codeName" value="<?= $_POST['codeName'] ?? $mission->getCodeName(); ?>" min="2" max="50" required>
        </div>

        <div class="my-3">
            <label for="codeCountry" class="form-label">Pays </label>
            <select id="codeCountry" class="form-select" name="codeCountry" required>
            <?php foreach($countryArray as $clef => $valeur){  ?>
                <option value="<?= $clef ?>" 
                    <?php if(isset($_POST['codeCountry'])){
                        if($_POST['codeCountry'] === $clef){ 
                            echo "selected"; 
                        }
                    } else {
                        if($mission->getCodeCountry() === $clef){ 
                            echo "selected"; 
                        }
                    } ?>
                ><?= $valeur ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="my-3">
        <label for="missionType" class="form-label">Type de mission</label>
        <select class="form-select" id="missionType"  name="missionType" required>
            <?php for($i=0; $i < count($allTypesOfMission); $i++) { ?>
            <option value="<?= $allTypesOfMission[$i]->getId(); ?>" 
                <?php if(isset($_POST['missionType'])){
                    if($_POST['missionType'] === $allTypesOfMission[$i]->getId()){
                        echo "selected";
                    }
                } else {
                    if($typeOfMissionId->getId() === $allTypesOfMission[$i]->getId()) { 
                        echo "selected";
                    } 
                } ?>
            ><?= $allTypesOfMission[$i]->getName(); ?></option>
            <?php } ?>
        </select>
        </div>

        <div class="my-3">
        <label for="speciality" class="form-label">Spécialité requise</label>
        <select class="form-select" id="speciality" name="speciality">
            <?php for($i=0; $i < count($allSpecialities); $i++) { ?>
            <option value="<?= $allSpecialities[$i]->getId(); ?>" 
                <?php if(isset($_POST['speciality'])){
                    if($_POST['speciality'] === $allSpecialities[$i]->getId()){
                        echo "selected";
                    }
                } else {
                    if($specialityByMission->getId() === $allSpecialities[$i]->getId()) { 
                        echo "selected"; 
                    }
                } ?>
            ><?= $allSpecialities[$i]->getName(); ?></option>
            <?php } ?>
        </select>
        </div>

        <div class="my-3">
            <p class="explication-msg" class="mb-3">Au moins un agent avec la spécialité requise.</p>
            <p class="form-label">Agent(s)</p>
            <div class="form-check">
            <?php for($i=0; $i < count($allSpies); $i++){ 
            $idSpy = $allSpies[$i]->getId();?>
                    <?php if(isset($_POST['optionSpy'])){ ?>
                            <input class="my-2" type="checkbox" 
                            id="<?= "spy" . $allSpies[$i]->getId(); ?>" 
                            name="optionSpy[]" 
                            value="<?= $allSpies[$i]->getId(); ?>" 
                                <?php if(in_array($allSpies[$i]->getId(), $_POST['optionSpy'])){ 
                                    echo "checked"; 
                                } else { 
                                        echo " ";
                                }?>
                            >
                            <label for="<?= "spy" . $allSpies[$i]->getId(); ?>">
                            <?= $allSpies[$i]->getFirstname() . " ". $allSpies[$i]->getLastName() . " - "  . $allSpies[$i]->getCountry() ?> <?= displaySpecialitiesBySpyInMissionForm($idSpy, $AllSpecialitiesBySpy) ?>
                            </label>
                            <br>

                    <?php }  else {?>
                        <input class="my-2" type="checkbox" id="<?= "spy" . $allSpies[$i]->getId(); ?>" name="optionSpy[]" value="<?= $allSpies[$i]->getId(); ?>"  
                            <?php if(in_array($allSpies[$i]->getId(), $spiesId)){ 
                                echo "checked"; 
                            } else { 
                                    echo " ";
                            }?>
                        >

                        <label for="<?= "spy" . $allSpies[$i]->getId(); ?>">
                        <?= $allSpies[$i]->getFirstname() . " ". $allSpies[$i]->getLastName() . " - "  . $allSpies[$i]->getCountry() ?> <?= displaySpecialitiesBySpyInMissionForm($idSpy, $AllSpecialitiesBySpy) ?>
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
            <?php for($i=0; $i < count($allTargets); $i++){ ?>
                <?php if(isset($_POST['optionTarget'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "target" . $allTargets[$i]->getId(); ?>" 
                    name="optionTarget[]" 
                    value="<?= $allTargets[$i]->getId(); ?>" 
                        <?php if(in_array($allTargets[$i]->getId(), $_POST['optionTarget'])){ 
                            echo "checked"; 
                        } else { 
                            echo " ";
                        }?>
                    >
                    <label for="<?= "target" . $allTargets[$i]->getId(); ?>">
                    <?= $allTargets[$i]->getFirstname() . " ". $allTargets[$i]->getLastName() . " - " . $allTargets[$i]->getCountry();?>
                    </label>
                    <br>
                <?php }  else {?>  
                    <input class="my-2" type="checkbox" 
                    id="<?= "target" . $allTargets[$i]->getId(); ?>" 
                    name="optionTarget[]" 
                    value="<?= $allTargets[$i]->getId(); ?>" 
                        <?php if(in_array($allTargets[$i]->getId(), $targetsId)){ 
                            echo "checked"; 
                        } else { 
                                echo " ";
                        }?>
                    >
                    <label for="<?= "target" . $allTargets[$i]->getId(); ?>">
                    <?= $allTargets[$i]->getFirstname() . " ". $allTargets[$i]->getLastName() . " - " . $allTargets[$i]->getCountry();?>
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
            <?php for($i=0; $i < count($allContacts); $i++){ ?>
                <?php if(isset($_POST['optionContact'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "contact" . $allContacts[$i]->getId(); ?>" 
                    name="optionContact[]" 
                    value="<?= $allContacts[$i]->getId(); ?>" 
                        <?php if(in_array($allContacts[$i]->getId(), $_POST['optionContact'])){ 
                            echo "checked"; 
                        } else { 
                            echo " ";
                        }?>
                    >
                    <label for="<?= "contact" . $allContacts[$i]->getId(); ?>">
                    <?= $allContacts[$i]->getFirstname() . " ". $allContacts[$i]->getLastName() . " - " . $allContacts[$i]->getCountry();?>
                    </label>
                    <br>
                    <?php } else {?> 
                        <input class="my-2" type="checkbox" 
                        id="<?= "contact" . $allContacts[$i]->getId(); ?>" 
                        name="optionContact[]" 
                        value="<?= $allContacts[$i]->getId(); ?>" 
                            <?php if(in_array($allContacts[$i]->getId(), $contactsId)){ 
                                echo "checked"; 
                            } else { 
                                echo " ";
                            }?>
                        >
                        <label for="<?= "contact" . $allContacts[$i]->getId(); ?>">
                        <?= $allContacts[$i]->getFirstname() . " ". $allContacts[$i]->getLastName() . " - " . $allContacts[$i]->getCountry();?>
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
            <?php for($i=0; $i < count($allHideouts); $i++){ ?>
                <?php if(isset($_POST['optionHideout'])){ ?>
                    <input class="my-2" type="checkbox" 
                    id="<?= "hideout" . $allHideouts[$i]->getId(); ?>" 
                    name="optionHideout[]" 
                    value="<?= $allHideouts[$i]->getId(); ?>" 
                        <?php if(!empty($hideoutsId)) { 
                            if(in_array($allHideouts[$i]->getId(), $_POST['optionHideout'])){ 
                                echo "checked"; 
                            } else { 
                                    echo " ";
                            } 
                        }?>
                    >
                    <label for="<?= "hideout" . $allHideouts[$i]->getId(); ?>">
                    <?= $allHideouts[$i]->getCodeName() . " - ". $allHideouts[$i]->getCountry() . " - " . $allHideouts[$i]->getType();?>
                    </label>
                    <br>
                <?php }  else {?> 
                    <input class="my-2" type="checkbox" 
                    id="<?= "hideout" . $allHideouts[$i]->getId(); ?>" 
                    name="optionHideout[]" 
                    value="<?= $allHideouts[$i]->getId(); ?>" 
                        <?php if(!empty($hideoutsId)) { 
                            if(in_array($allHideouts[$i]->getId(), $hideoutsId)){ 
                                echo "checked"; 
                            } else { 
                                echo " ";
                            } 
                        }?>
                    >
                    <label for="<?= "hideout" . $allHideouts[$i]->getId(); ?>">
                    <?= $allHideouts[$i]->getCodeName() . " - ". $allHideouts[$i]->getCountry() . " - " . $allHideouts[$i]->getType();?>
                    </label>
                    <br>
                <?php } ?>
            <?php } ?>
            </div>
        </div>

        <div class="my-3">
            <label for="startDate" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="startDate" name="startDate" value="<?= $_POST['startDate'] ?? $mission->getStartDate(); ?>" required>
        </div>

        <div class="my-3">
            <label for="endDate" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="endDate" name="endDate" value="<?= $_POST['endDate'] ?? $mission->getEndDate(); ?>" required>
        </div>
        <button type="submit" class="btn btn-info btn-lg align-self-center">Valider</Button>
    </form>
</div>

<div class="d-flex flex-column align-items-start">
    <a class="btn btn-info " href="<?= URL ?>missions/list/<?= $mission->getId(); ?>">Retour à la mission</a>
    <br>
    <a class="btn btn-info" href="<?= URL ?>missions">Retour aux missions</a>
</div>


<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Modification mission";
$src = URL . "script/script-connexion.js";

require "views/common/template.php";