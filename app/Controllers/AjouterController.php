<?php

namespace Ebook\Controllers;

use Ebook\Models\Livres;

class AjouterController extends CoreController
{
    public function ajouter($id_user)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupérer les données du formulaire
            $auteurNom = $_POST['auteurNom'];
            $auteurPrenom = $_POST['auteurPrenom'];
            $titre = $_POST['Titre'];

            // Créer un nouveau livre
            $livre = new Livres();

            // Affecter les données au modèle
            $livre->setAuteurNom($auteurNom);
            $livre->setAuteurPrenom($auteurPrenom);
            $livre->setTitre($titre);

            // Sauvegarder le livre
            $livre->add($id_user);

            // Rediriger vers la liste des livres
            // header('Location: http://localhost/Ebook/public/');
            header('Location:'.$_SERVER['BASE_URI'].'/livres');
            exit;
        }

        $this->show('ajouter');
    }
}