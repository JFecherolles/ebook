<?php

namespace Ebook\Controllers;

use Ebook\Models\Livres;

class AjouterController extends CoreController
{
    public function ajouter()
    {
        // Si le formulaire est soumis
        // $_SERVER c est une variable superglobale qui contient des informations sur les en-têtes, 
        // chemins et emplacements du script. Les entrées de cette table sont créées par le serveur web et ne doivent pas être modifiées par le programme.
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
            $livre->add(id_user: 1);

            // Rediriger vers la liste des livres
            // header('Location: http://localhost/Ebook/public/');
            header('Location:'.$_SERVER['BASE_URI'].'/');
            exit;
        }

        $this->show('ajouter');
    }
}
