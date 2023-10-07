<div class="container my-4">
    <a href="<?= $router->generate('user-list'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un utilisateur</h2>
    
    <!-- on inclut le formulaire add/update -->
    <?php include __DIR__ . '/form.tpl.php'; ?>

</div>