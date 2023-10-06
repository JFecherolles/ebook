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
    'controller' => 'Ebook\controller\MainController'
], 'home');

$router->map('GET', '/ajouter', [
    'action' => 'ajouter',
    'controller' => 'Ebook\controller\AjouterController'
], 'ajouter');

$router->map('POST', '/ajouter', [
    'action' => 'ajouter',
    'controller' => 'Ebook\controller\AjouterController'
], 'ajouter_post');

$router->map('POST', '/', [
    'action' => 'update',
    'controller' => 'Ebook\controller\LivreController'
], 'modification');

$router->map('POST', '/supprDb', [
    'action' => 'delete',
    'controller' => 'Ebook\controller\LivreController'
], 'suppression');


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
    $controller = new Ebook\controller\ErrorController();
    $controller->error404();
}

//Fin altorouteur

?>


