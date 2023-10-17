<form method="POST" class="mt-3">
<div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="ex. robert@dupont.fr" value="<?= $user->getEmail() ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="" value="<?= $user->getPassword() ?? '' ?>">
        <div class="form-text">Doit contenir au moins 8 caractères, une lettre en minuscule/majuscule, au moins un chiffre, au moins un caractère spécial.</div>
    </div>

    <button type="submit" class="btn btn-primary mt-5">Valider</button>
    </div>
</form>