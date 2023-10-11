<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// on instancie la classe AltoRouter
$router = new AltoRouter();

// on doit dire à Altorouter dans quel dossier se trouve notre app
// pour qu'il puisse "differencier" les routes demandées par l'utilisateur du dossier dans leqquel se trouve notre app
$router->setBasePath($_SERVER['BASE_URI']);

// on map nos routes
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

$router->map('GET', '/user/login', [
    'action' => 'login',
    'controller' => '\Ebook\Controllers\UserController'
], 'user-login');

$router->map('POST', '/user/login', [
    'action' => 'connect',
    'controller' => '\Ebook\Controllers\UserController',
], 'user-connect');

$router->map('GET', '/user/logout', [
    'action' => 'logout',
    'controller' => '\Ebook\Controllers\UserController'
], 'user-logout');

$router->map('GET', '/user/list', [
    'action' => 'list',
    'controller' => '\Ebook\Controllers\UserController',
], 'user-list');

$router->map('GET', '/user/add', [
    'action' => 'add',
    'controller' => '\Ebook\Controllers\UserController',
], 'user-add');

$router->map('POST','/user/add', [
    'action' => 'create',
    'controller' => '\Ebook\Controllers\UserController', 
], 'user-create');

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
    $controller = new Ebook\Controllers\ErrorController();
    $controller->error404();
}

