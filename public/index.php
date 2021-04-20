<?php

// On include les dépendances Composer
require __DIR__ . '/../vendor/autoload.php';

session_start();

/* ---------------------------------------------------------------------------------------
--------------------------------------- MAPPING ------------------------------------------
-----------------------------------------------------------------------------------------*/

// On instancie l'objet AltoRouter qui va mapper nos routes
$router = new AltoRouter;

// je défini la base uri qui est définie dans le fichier .htaccess
$router->setBasePath($_SERVER['BASE_URI']);



/* --------------------------------- LISTE DES ROUTES -----------------------------------*/

/* ---------------------------------- Page d'accueil ------------------------------------*/

$router->map(
    'GET',
    '/',
    'MainController::home',
    'main-home'
);

/* ----------------------------- Auteurs et leurs photos --------------------------------*/

$router->map(
    'GET',
    '/auteurs',
    'AuthorController::browse',
    'author-browse'
);

$router->map(
    'GET',
    '/auteurs/photos/[i:author_id]',
    'ShotController::browseByAuthor',
    'shot-browseByAuthor'
);

/* -------------------------- Connexion et authentification ----------------------------*/

$router->map(
    'GET',
    '/login',
    'AdminController::login',
    'admin-login'
);

$router->map(
    'POST',
    '/login',
    'AdminController::authenticate',
    'admin-authenticate'
);

$router->map(
    'GET',
    '/logout',
    'AdminController::logout',
    'admin-logout'
);

/* ----------------------------------- CRUD Profil ------------------------------------*/

$router->map(
    'GET',
    '/profil',
    'UserController::showProfil',
    'user-showprofil'
);

$router->map(
    'GET',
    '/profil/modifier',
    'UserController::editProfil',
    'user-editprofil'
);

$router->map(
    'POST',
    '/profil/modifier',
    'UserController::updateProfil',
    'user-updateprofil',
);

/* ----------------------------------- CRUD Shots -------------------------------------*/

$router->map(
    'GET',
    '/shots/liste',
    'ShotController::list',
    'shot-list'
);

$router->map(
    'GET',
    '/shots/ajouter',
    'ShotController::add',
    'shot-add'
);

$router->map(
    'POST',
    '/shots/ajouter',
    'ShotController::create',
    'shot-create'
);

$router->map(
    'GET',
    '/shots/modifier/[i:id]',
    'ShotController::edit',
    'shot-edit'
);

$router->map(
    'POST',
    '/shots/modifier/[i:id]',
    'ShotController::update',
    'shot-update'
);

$router->map(
    'GET',
    '/shots/[i:id]/supprimer',
    'ShotController::delete',
    'shot-delete'
);

/* ---------------------------------- CRUD Authors ------------------------------------*/

$router->map(
    'GET',
    '/auteurs/liste',
    'AuthorController::list',
    'author-list'
);

$router->map(
    'GET',
    '/auteurs/ajouter',
    'AuthorController::add',
    'author-add'
);

$router->map(
    'POST',
    '/auteurs/ajouter',
    'AuthorController::create',
    'author-create'
);

$router->map(
    'GET',
    '/auteurs/modifier/[i:id]',
    'AuthorController::edit',
    'author-edit'
);

$router->map(
    'POST',
    '/auteurs/modifier/[i:id]',
    'AuthorController::update',
    'author-update'
);

$router->map(
    'GET',
    '/auteurs/[i:id]/supprimer',
    'AuthorController::delete',
    'author-delete'
);

/* ----------------------------------- CRUD Users ------------------------------------*/

$router->map(
    'GET',
    '/utilisateurs/liste',
    'UserController::list',
    'user-list'
);


$router->map(
    'GET',
    '/utilisateurs/ajouter',
    'UserController::add',
    'user-add'
);

$router->map(
    'POST',
    '/utilisateurs/ajouter',
    'UserController::create',
    'user-create'
);

$router->map(
    'GET',
    '/utilisateurs/modifier/[i:id]',
    'UserController::edit',
    'user-edit'
);

$router->map(
    'POST',
    '/utilisateurs/modifier/[i:id]',
    'UserController::update',
    'user-update'
);

$router->map(
    'GET',
    '/utilisateurs/[i:id]/supprimer',
    'UserController::delete',
    'user-delete'
);


/* ---------------------------------------------------------------------------------------
--------------------------------------- DISPATCH -----------------------------------------
-----------------------------------------------------------------------------------------*/

// on demande à AltoRouter de comparer les routes 
// grâce à sa méthode match()
$match = $router->match();

// j'instancie le dispatcher à qui je donne le résultat de match
// et la méthode 'err404' à appeler si les routes ne matchent pas
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// je viens préciser le namespace pour tous mes controllers
$dispatcher->setControllersNamespace('App\Controllers');

// je définie les arguments que j'envoie à mes controllers 
// comme j'ai un ACL, je dois leur donner le nom des routes à vérifier
// en leur passant la valeur du tableau $match à l'entrée 'name' (nom de la route)
// et je conditionne pour ne pas avoir d'erreur s'il ne trouve pas de route
// exemple pour une 404, route non trouvée
if ($match) {
    $dispatcher->setControllersArguments(
        $match['name'],
    );
};

// je lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();