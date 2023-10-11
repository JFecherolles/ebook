<?php

namespace Ebook\Controllers;

class CoreController
{
    /**
     * Méthode appelée à chaque instanciation d'un objet
     * Dès qu'on faut un new XxxController();
     */
    public function __construct()
    {
        // les infos reçues d'Altorouter sur l'index
        global $match;


        // la route dont on souhaite vérifier l'autorisation
        // donc la route demandée par la requête HTTP
        // se trouve-t-elle dans la l'ACL ?
        // cette route se trouve dans le $match d'Altorouter
        $routeName = $match['name'];
        // dump($routeName); 

        // vérification des tokens CSRF sur *les pages nécessaires*
        $csrfTokenRoutes = [
            'user-create',
        ];

        // si route demandée présente dans la liste, on vérifie le token
        if (in_array($routeName, $csrfTokenRoutes)) {
            $this->checkCsrfToken();
        }
    }

    /**
     * Vérification du token CSRF
     */
    public function checkCsrfToken()
    {
        // on récupère le token du form (en POST) s'il existe
        $postToken = $_POST['csrf_token'] ?? '';

        // on récupère le token en session
        $sessionToken = $_SESSION['csrfToken'] ?? '';

        // si le token reçu esy différent du token en session
        // ou que le token reçu est vide
        if ($postToken != $sessionToken || empty($postToken)) {
            // si oui => 404 Forbidden
            $errorController = new ErrorController();
            $errorController->error404();
            exit;
        }

        // sinon on continue vers la route demandée
        // et on supprime le token en session pour qu'il soit à usage unique
        unset($_SESSION['csrfToken']);
    }

    /**
     * Méthode qui vérifie si le user a la permission d'accéder ou non à la page demandée
     * 
     * @param array $authorizedRoles Les rôles autorisés
     */
    protected function checkAuthorization()
    {
        // on récupère le token du form (en POST) s'il existe
        $postToken = $_POST['csrf_token'] ?? '';

        // on récupère l'identifiant unique du token en session
        $uniqueIdentifier = $_POST['csrf_token_identifier'] ?? '';

        // on récupère le token en session à partir de l'identifiant unique
        $sessionToken = $_SESSION['csrfTokens'][$uniqueIdentifier] ?? '';

        // si le token reçu est différent du token en session
        // ou que le token reçu est vide
        if ($postToken != $sessionToken || empty($postToken) || empty($uniqueIdentifier)) {
            // si oui => 404 Forbidden
            $errorController = new ErrorController();
            $errorController->error404();
            exit;
        }

        // sinon on continue vers la route demandée
        // et on supprime le token en session pour qu'il soit à usage unique
        unset($_SESSION['csrfTokens'][$uniqueIdentifier]);

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

        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        // @see https://www.php.net/manual/en/function.extract.php
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
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
        // Générer un identifiant unique à chaque fois que la méthode est appelée
        $uniqueIdentifier = bin2hex(random_bytes(8));

        // Générer une chaine aléatoire non-reproductible
        $csrfToken = bin2hex(random_bytes(32));

        // Stocker le jeton CSRF dans une clé de session unique
        $_SESSION['csrfTokens'][$uniqueIdentifier] = $csrfToken;

        // Retourner le jeton CSRF
        return $csrfToken;
    }
}
