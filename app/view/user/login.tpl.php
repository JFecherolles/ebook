<div class="container my-4">
    <div class="text-center">
        <h1>Connexion</h1>
    </div>


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

            <input type="hidden" name="csrf_token" value="<?= $this->generateToken(); ?>">

            <button type="submit" class="btn btn-primary">Connexion</button>
            <a href="<?= $router->generate('user-add') ?>" class="btn btn-success">S'inscrire</a>
        </div>
    </form>
</div>