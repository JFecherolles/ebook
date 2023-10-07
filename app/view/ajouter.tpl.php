<div class="container">
    <div class="text-center">
        <h1>Ajouter un livre</h1>
    </div>
    <form method="post" action="">
        <div class="form-group">
            <label for="auteurNom">Nom de l'auteur :</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="auteurNom" name="auteurNom" required>
            </div>
        </div>
        <div class="form-group">
            <label for="auteurPrenom">Prénom de l'auteur :</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="auteurPrenom" name="auteurPrenom" required>
            </div>
        </div>
        <div class="form-group">
            <label for="Titre">Titre du livre :</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="Titre" name="Titre" required>
            </div>
        </div><br>
        <button type="submit" class="btn btn-primary">Ajouter le livre</button>
    </form>
</div>