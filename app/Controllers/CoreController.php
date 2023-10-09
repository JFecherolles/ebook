<?php

namespace Ebook\Controllers;

class CoreController
{
    public function show($viewName, $viewData = [])
    {
        // $viewVars est disponible dans chaque fichier de vue
        // et contient toutes les variables que l'on souhaite envoyer à la vue
        // on extrait les variables du tableau pour les rendre disponibles dans la vue
        global $router;

        // on inclut le fichier de vue
        // le chemin est relatif à partir du dossier app/
        require_once __DIR__ . '/../view/header.tpl.php';
        require_once __DIR__ . '/../view/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../view/footer.tpl.php';
    }
}