<?php

namespace Ebook\Controllers;

class CoreController
{
    /**
     * Méthode appelée à chaque instanciation d'un objet
     * Dès qu'on faut un new XxxController();
     */
    
    protected function checkAuthorization()
    {
        // un user doit être connecté
        if (isset($_SESSION['userObject'])) {
            // on récupère le user dans la session
            $user = $_SESSION['userObject'];
            // si non => 403 Forbidden
            $errorController = new ErrorController();
            $errorController->error404();
            exit;
        }

        // si non, on le redirige vers le login
        global $router;
        header('Location: ' . $router->generate('user-login'));
        exit;
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        // @see https://www.php.net/manual/en/function.extract.php
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../view/header.tpl.php';
        require_once __DIR__ . '/../view/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../view/footer.tpl.php';
    }

    /**
     * Génère un token CSRF
     */
    protected function generateToken()
    {
        // on génère une chaine aléatoire non-reproductible
        $csrfToken = bin2hex(random_bytes(32));
        // on le met en session
        $_SESSION['csrfToken'] = $csrfToken;
        // on le retourne
        return $csrfToken;
    }
}