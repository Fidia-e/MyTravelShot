<?php

// On include les dépendances Composer
require __DIR__ . '/../vendor/autoload.php';

// session_start();

/* ---------------------------------------------------------------------------------------
--------------------------------------- MAPPING ------------------------------------------
-----------------------------------------------------------------------------------------*/

// On instancie l'objet AltoRouter qui va mapper nos routes
$router = new AltoRouter;

// je défini la base uri qui est définie dans le fichier .htaccess
$router->setBasePath($_SERVER['BASE_URI']);



/* --------------------------------- liste des routes -----------------------------------*/

/* ---------------------------------- Page d'accueil ------------------------------------*/

$router->map(
    'GET',
    '/',
    'MainController::home',
    'main-home'
);

/* ------------------------------------- Auteurs ---------------------------------------*/

$router->map(
    'GET',
    '/auteurs',
    'AuthorController::browse',
    'author-browse'
);

$router->map(
    'GET',
    '/auteurs/modifier/[i:id]',
    'AuthorController::edit',
    'author-edit'
);

/* ---------------------------------- Utilisateurs ------------------------------------*/

$router->map(
    'GET',
    '/utilisateurs',
    'UserController::browse',
    'user-browse'
);



/* ---------------------------------------------------------------------------------------
--------------------------------------- DISPATCH -----------------------------------------
-----------------------------------------------------------------------------------------*/

// On demande à AltoRouter de comparer les routes 
// grâce à sa méthode match()
$match = $router->match();

// j'instancie le dispatcher à qui je donne le résultat de match
// et la méthode à appeler si les routes ne matchent pas
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// je viens préciser le namespace pour tous mes controllers
$dispatcher->setControllersNamespace('App\Controllers');

// je définie les arguments que j'envoie à mon controller
$dispatcher->setControllersArguments(
    $match['name'],
);

// je lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();