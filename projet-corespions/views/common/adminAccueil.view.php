<?php
ob_start();
?>

<h2>Panneau d'administration</h2>
<br>

    <div class="d-flex flex-column align-items-center">
        <div id="container-btn-admin-pannel" class="d-flex justify-items-center container-btn-admin-pannel">
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>missions">Missions</a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>spies">Agents</a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>targets">Cibles</a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>contacts">Contacts </a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>hideouts">Planques</a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>specialities/add">Spécialités</a>
            <a class="btn btn-info btn-lg m-2 main-link" href="<?= URL ?>typesOfMission/add">Types de mission</a>
        </div>
        <div class="m-3">
            <div class="text-container-admin mt-4">
                <h3 class="text-center my-4">Consignes générales</h3>
                <p class="text-center">Vous pouvez ajouter des éléments, les modifier ou les supprimer à condition qu'ils ne soient pas indispensable à un autre élément.</p>
                <p class="text-center">Par exemple, vous ne pouvez pas supprimer un agent qui est rattaché à une ou plusieurs missions. Il faudra d'abord affecter un autre agent à ce ou ces missions afin de pouvoir le supprimer.</p>
                <p class="text-center">Les boutons "supprimer" seront uniquement disponibles si l'élément peut bien être supprimé.</p>
                <h3 class="text-center my-4">Consignes spécifiques</h3>
                <p class=""><span>&#8611; </span>le(s) agent(s) ne doit pas avoir la même nationalité que la ou les cibles.</p>
                <p class=""><span>&#8611; </span>Le(s) contact(s) est obligatoirement de la nationalité du pays de la mission.</p>
                <p class=""><span>&#8611; </span>La (ou les) planque n'est pas obligatoire mais si elle(s) existe, elle(s) doit être dans le même pays que la mission.</p>
                <p class=""><span>&#8611; </span>Sur une mission, au moins un agent doit disposer de la spécialité requise à la mission.</p>
           </div>
        </div>
    </div>

<?php
$content = ob_get_clean();

$preContent = "";
$titleHead = "Administration Corespions";
$src ="";

require "views/common/template.php";
