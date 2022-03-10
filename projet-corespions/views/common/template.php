<html lang="fr">
  <head>
    <title><?= $titleHead ?></title>
    <meta charset="utf-8">
    <meta name="description" content="Corespions est une société privée (totalement fictive) d'espionnage. Nous sommes à votre disposition pour toutes vos idées de sabotage, de vengeance et d'espionnage.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>style/style.css">
  </head>
  <body>
    <header class="d-flex justify-content-between align-items-center">
    <h1><a href="<?= URL ?>home">Corespions</a></h1>

    <?php if(!isset($_SESSION["access"])){ ?>
      <a class="btn btn-co" href="<?= URL ?>login">Connexion</a>
      </header>
      <main>
      <div id="main-intro" class="d-flex justify-content-center">
          <section class="d-flex justify-content-center flex-column">
            <h2>Qui sommes nous ?</h2>
            <br>
            <p id="citation">Corespions : Au coeur de l'espionnage</p>
            <p>Corespions est une société privée (totalement fictive) d'espionnage. Nous sommes à votre disposition pour toutes vos idées de vengeance et de sabotage. Nous n'hésitons pas à nous salir les mains, nous n'avons absolument aucune valeur tant qu'il y a un contrat à la clef.
            </p>
          </section>
          <img src="<?= URL ?>images/image1.jpg" alt="">
      </div>
    <?php } else if(isset($_SESSION["access"])){ ?>
      <div class="d-flex flex-column">
        <form method="POST" action="">
            <input type='hidden' name='deconnexion' value="true" />
            <button class="btn btn-co" "type="submit">Se déconnecter</button>
        </form>
        <a class="btn btn-co" href="<?= URL ?>admin">Administration</a>
    </div>
    </header>
    <main>
    <?php } ?>
      <div id="main-content">
      <?php if(isset($_SESSION['access'])){ ?>
      <div class="dropdown">
        <a class="btn btn-light btn-lg dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          Menu
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="<?= URL ?>admin">Accueil</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>missions">Missions</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>spies">Agents</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>targets">Cibles</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>contacts">Contacts</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>hideouts">Planques</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>specialities/add">Spécialités</a></li>
          <li><a class="dropdown-item" href="<?= URL ?>typesOfMission/add">types de mission</a></li>
        </ul>
      </div>
      <br>
      <?php } else {
        echo $preContent;
      } ?>

        <?= $content ?>
      
      </div>
    </main>

    <footer class="d-flex justify-content-center">
      <div class="d-flex flex-column">
        <p id="footer-title">Contact</p>
        <div class="d-flex flex-column">
            <p>15 rue de l'espoir - 122345 Planète Mars</p> 
            <p>01.02.03.04.05</p> 
            <p>Corespions@mail.fr</p>
        <div>
          <br>
        <div>
            <p>&#169; Corespions <?= date('Y', time()); ?></p>
        </div>
      </div>
    </footer>
  <script type="text/javascript" src="<?= URL ?>script\bootstrap.min.js"></script>
  <script type="text/javascript" src="<?= URL ?>script\bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?= $src ?>"></script>
  </body>
</html>
