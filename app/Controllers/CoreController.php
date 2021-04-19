<?php

namespace App\Controllers;

use App\Controllers\ErrorController;

// je crée ma class CoreController
// qui je définie en abstract
// pour indiquer qu'elle ne sera jamais instanciée
// mais seulement héritée
abstract class CoreController {
    
    // on définie un constructeur qui sera appelé 
    // dans tous les controlleurs
    // on lui passe $route = false en argument
    // pour que les routes qui ne sont pas listées dans l'acl
    // restent accessibles 
   public function __construct($route = false)
   {
    // ACL Access Control List :
    // définition du tableau contenant les routes 
    // qui sont resteintes pour certains rôles
    // Comment ça fonctionne :
    //      1- si la route n'est pas dans la liste, alors elle est accessible à tous (hors connexion)
    //      2- [] => il faut être connecté pour y avoir accès
    //      3- les rôles listés dans le tableaux ont accès à la route correspondante
      $acl = [
           
         'shot-list' => [],
         'shot-add' => [],
         'shot-create' => [],
         'shot-edit' => [],
         'shot-update' => [],
         'shot-delete' => [],

         'author-list' => [],
         'author-add' => ['admin', 'superadmin'],
         'author-create' => ['admin', 'superadmin'],
         'author-edit' => ['admin', 'superadmin'],
         'author-update' => ['admin', 'superadmin'],
         'author-delete' => ['admin', 'superadmin'],

         'user-list' => [],
         'user-add' => ['superadmin'],
         'user-create' => ['superadmin'],
         'user-edit' => ['superadmin'],
         'user-update' => ['superadmin'],
         'user-delete' => ['superadmin'],

         'user-showprofil' => [],
         'user-editprofil' => [],
         'user-updateprofil' => [],

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
		global $router; 
			
		// je définie ma base uri, chemin absolu du mon projet
		$viewVars['baseUri'] = $_SERVER['BASE_URI'];

		// je définie la route absolue pour mes assets
		$viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';

		// je définie le nom de mes routes
		$viewVars['currentPage'] = $viewName;

		// je donne accès aux données du tableau viewVars
		// en faisant ça, je définie toutes les entrées du tableau viewVars comme étant de nouvelles variables
		// exemple: maintenant les variables $assetsBaseUri, $currentPage, $baseUri existent
		extract($viewVars);

		// j'appelle mes vues
		// à la place de $viewName, je mets le chemin dynamisé des templates
		require __DIR__ . '/../views/header.tpl.php';
		require __DIR__ . '/../views/' . $viewName . '.tpl.php';
		// require __DIR__ . '/../views/footer.tpl.php';
	}

    /**
     * Méthode permettant de rediriger l'utilisateur, dans tous les controllers.
     */
     public function redirect($route) 
    {
        global $router;

        header('Location: '. $router->generate($route));
    }

    /**
     * Méthode permettant de générer un token aléatoire pour prévenir les attaques CSRF
	 * ce token sera stocké en session et renvoyé afin d'être placé dans les formulaires / liens à protéger
     * le principe étant de comparer le token de la session avec celui du formulaire
     *
     * @return string
     */
	 protected function generateCsrfToken()
	{
        // je génère un token de manière aléatoire
        // d'une longueur de 10 caractères 
        // que je vais devoir passer à mes formulaires
		$bytes = random_bytes(10);
		$token = bin2hex($bytes);

        // et ici, je le passe à ma session
		$_SESSION['csrfToken'] = $token;

		return $token;
	}

	/**
     * Méthode vérifiant que le token passé correspond bien à celui stocké en session
     *
     */
     protected function checkCsrfToken($method)
    {
        if($method == 'post') {
            // on récupère le token en POST
            $token = filter_input(INPUT_POST, 'token');
        } else if ($method == 'get') {
            // on récupère le token en GET
            $token = filter_input(INPUT_GET, 'token');
        }

        // Récupération du token de session
        $sessionToken = $_SESSION['csrfToken'];

        // ce que je vérifie : 
            // 1- présence du token dans le formulaire ? 
            // 2- présence du token dans la session ? 
            // 3- est-ce que les deux token correspondent ?

        if(empty($token) || empty($sessionToken) || $token != $sessionToken){
            // si les trois conditions ne sont pas remplies,
			// alors je bloque l'accès à la page protégée par le token CSRF
			// et j'affiche l'erreur 403 (forbidden)
            $errorController = new ErrorController;
            $errorController->err403();
        }
    }

}