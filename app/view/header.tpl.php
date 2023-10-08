<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>Ebook</title>
</head>

<body>

  <header class="">
    <nav class="navbar navbar-expand-md bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('home') ?>">Ebook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav text-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="<?= $router->generate('home') ?>">Acceuil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-warning" href="<?= $router->generate("ajouter") ?>" data-bs-target="#ModalAjout">Ajouter</a>
            </li>
            <?php if (isset($_SESSION['userId'])) : ?>
              <li class="nav-item">
                <a class="nav-link btn btn-success" href="<?= $router->generate('user-logout') ?>">Déconnexion</a>
              </li>
             
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link active
                " href="<?= $router->generate('user-login') ?>">Connexion</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>