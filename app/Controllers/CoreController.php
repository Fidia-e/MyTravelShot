<?php

namespace App\Controllers;

use App\Controllers\ErrorController;
use App\Models\Shot;
// use App\Models\Author;
// use App\Models\User;

abstract class CoreController {

   public function __construct($routeName = false)
   {
      $aclList = [
         'main-home' => [],
         'shot-browseByAuthor' => [],
         'admin-login' => ['user','admin'],
         'author-browse'=> ['admin'],
         'author-add'=> ['admin'],
         'author-edit'=> ['admin'],
         'user-browse'=> ['admin'],
         'user-add'=> ['admin'],
         'user-edit'=> ['admin'],
       
     ];
   }

    /**
     * Méthode qui se charge d'afficher mes vues
     *
     * @param string $viewName (nom du fichier de la vue)
     * @param array (optional) (tableau des données que je transmets à la vue)
     * @return void (vide)
     */

     protected function show(string $viewName, $viewVars = [])
     {
        // je définie ma base uri, chemin absolu du mon projet
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        // je définie la route absolue pour mes assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';

        // je définie le nom de mes routes
        $viewVars['currentPage'] = $viewName;

        // je donne accès aux données du tableau viewVars
        extract($viewVars);

        // j'appelle mes vues
        require __DIR__ . '/../views/header.tpl.php';
        require __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require __DIR__ . '/../views/footer.tpl.php';
     }
}