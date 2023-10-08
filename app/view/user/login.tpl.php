<div class="container my-4">

    <h2>Connexion</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="ex. toto@gmail.com" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Connexion</button>
            <a href="<?= $router->generate('user-add') ?>" class="btn btn-success">S'inscrire</a>
        </div>
    </form>
</div>