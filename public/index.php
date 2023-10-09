<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// on instancie la classe AltoRouter
$router = new AltoRouter();

// on doit dire à Altorouter dans quel dossier se trouve notre app
// pour qu'il puisse "differencier" les routes demandées par l'utilisateur du dossier dans leqquel se trouve notre app
$router->setBasePath($_SERVER['BASE_URI']);

// on map nos routes
// Page d'accueil
$router->map('GET', '/',[
    'action' => 'home',
    'controller' => 'Ebook\Controllers\MainController'
], 'home');

$router->map('GET', '/livres',[
    'action' => 'livres',
    'controller' => 'Ebook\Controllers\MainController'
], 'livres');

$router->map('GET', '/ajouter', [
    'action' => 'ajouter',
    'controller' => 'Ebook\Controllers\AjouterController'
], 'ajouter');

$router->map('POST', '/ajouter', [
    'action' => 'ajouter',
    'controller' => 'Ebook\Controllers\AjouterController'
], 'ajouter_post');

$router->map('POST', '/', [
    'action' => 'update',
    'controller' => 'Ebook\Controllers\LivreController'
], 'modification');

$router->map('POST', '/supprDb', [
    'action' => 'delete',
    'controller' => 'Ebook\Controllers\LivreController'
], 'suppression');

$router->map(
    'GET',
    '/user/login',
    [
        'action' => 'login',
        'controller' => '\Ebook\Controllers\UserController'
    ],
    'user-login'
);

// user login connect
$router->map(
    'POST',
    '/user/login',
    [
        'action' => 'connect',
        'controller' => '\Ebook\Controllers\UserController', // On indique le FQCN de la classe
    ],
    'user-connect'
);

// user login out
$router->map(
    'GET',
    '/user/logout',
    [
        'action' => 'logout',
        'controller' => '\Ebook\Controllers\UserController'
    ],
    'user-logout'
);

// user list
$router->map(
    'GET',
    '/user/list',
    [
        'action' => 'list',
        'controller' => '\Ebook\Controllers\UserController', // On indique le FQCN de la classe
    ],
    'user-list'
);

// user add (affiche le form)
$router->map(
    'GET',
    // URL en GET
    '/user/add',
    [
        'action' => 'add',
        'controller' => '\Ebook\Controllers\UserController', // On indique le FQCN de la classe
    ],
    // nom de route pour générer les URLs via $router->generate('nom-de-la-route')
    'user-add'
);

// user add (traite le form)
$router->map(
    'POST',
    '/user/add',
    [
        'action' => 'create',
        'controller' => '\Ebook\Controllers\UserController', // On indique le FQCN de la classe
    ],
    // nom de route pour générer les URLs via $router->generate('nom-de-la-route')
    'user-create'
);


// on "match" la requête actuelle avec nos routes enregistrées précédemment
$match = $router->match();

// si match = true, la route existe
if($match) {
    // comme avant, on veut récupérer le controleur à instancier 
    // et la méthode de ce controleur à appeler
    // sauf que ce coup-ci, on le fait grâce à AltoRouter !
    $controllerToInstantiate = $match['target']['controller'];
    $methodToCall = $match['target']['action'];

    // dispatcheur :
    $controller = new $controllerToInstantiate();
    // on appelle notre méthode, et on lui envoie les paramètres d'URL
    $controller->$methodToCall($match['params']);

} else {
    // 404, la route existe pas
    $controller = new Ebook\Controllers\ErrorController();
    $controller->error404();
}

//Fin altorouteur

?>
