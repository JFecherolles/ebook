<main class="">


  <section class="pt-3 w-50 m-auto">
    <div class="input-group mb-3">
      <input type="search" class="form-control form-control-sm table-filter" placeholder="Rechercher un livre" data-table="table">
    </div>
  </section>

  <section class="container text-center">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Prénom</th>
          <th scope="col">Nom</th>
          <th scope="col">Titre</th>
          <th scope="col">Mod / Suppr</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($viewData['listLivre'] as $value) : ?>
          <tr>
            <td><?= $value->getAuteurPrenom() ?></td>
            <td><?= $value->getAuteurNom() ?></td>
            <td><?= $value->getTitre() ?></td>
            <td>
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $value->getId() ?>" id="mod-button">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                </svg></a>
              /
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#ModalSuppr<?= $value->getId() ?>" id="mod-button">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg></a>

              <!-- MODAL MODIF -->
              <div class="modal fade" id="exampleModal<?= $value->getId() ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="<?= $router->generate('modification') ?>" method="POST">
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Prenom Auteur</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getAuteurPrenom() ?>" name="auteurPrenom" required>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Nom Auteur</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getAuteurNom() ?>" name="auteurNom" required>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Titre</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getTitre() ?>" name="Titre" required>
                          <input type="hidden" name="id" value="<?= $value->getId() ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                      <button class="btn btn-primary">Enregistrer</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- FIN MODAL -->

              <!-- MODAL SUPPR -->
              <div class="modal fade" id="ModalSuppr<?= $value->getId() ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="<?= $router->generate('suppression') ?>" method="POST">
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Prénom Auteur</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getAuteurPrenom() ?>" name="firstname">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Nom Auteur</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getAuteurNom() ?>" name="lastname">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Titre</span>
                          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $value->getTitre() ?>" name="title">
                          <input type="hidden" name="idlivre" value="<?= $value->getId() ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                      <button class="btn btn-danger">Supprimer</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- FIN MODAL -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>