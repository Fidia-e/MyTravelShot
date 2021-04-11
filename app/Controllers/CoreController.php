<?php

namespace App\Controllers;

use App\Controllers\ErrorController;

// je crée ma class CoreController
// qui je définie en abstract
// pour indiquer qu'elle ne sera jamais instanciée
// mais seulement héritée
abstract class CoreController {

   // public function __construct($routeName = false)
   // {
   //    $aclList = [
   //       'main-home' => [],
   //       'shot-browseByAuthor' => [],
   //       'admin-login' => ['user','admin'],
   //       'author-browse'=> ['admin'],
   //       'author-add'=> ['admin'],
   //       'author-edit'=> ['admin'],
   //       'user-browse'=> ['admin'],
   //       'user-add'=> ['admin'],
   //       'user-edit'=> ['admin'],
   //   ];
   // }

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
		require __DIR__ . '/../views/footer.tpl.php';
	}

    /**
     * Méthode permettant de générer un token aléatoire pour prévenir les attaques CSRF
	 * ce token sera stocké en session et renvoyé afin d'être placé dans les formulaires / liens à protéger
     *
     * @return string
     */
	 protected function generateCsrfToken()
	{
		$bytes = random_bytes(10);
		$token = bin2hex($bytes);

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
            // On récupère le token en POST
            $token = filter_input(INPUT_POST, 'token');
        } else if ($method == 'get') {
            // On récupère le token en GET
            $token = filter_input(INPUT_GET, 'token');
        }

        // Récupération du token de session
        $sessionToken = $_SESSION['csrfToken'];

        // Tests à faire : 
            // - Présence du token du formulaire ? 
            // - Présence du token en session ? 
            // - Correspondance entre les deux tokens ?

        if(empty($token) || empty($sessionToken) || $token != $sessionToken){
            // si on ne remplit aucune des trois conditions, 
			// alors on n'a pas le droit d'accéder à notre page protégée par le token CSRF
			// j'affiche donc l'erreur 403 (forbidden).
            $errorController = new ErrorController;
            $errorController->err403();
        }
    }

	/**
	 * Méthode permettant de rediriger l'utilisateur, dans tous les controllers.
	 */
	 public function redirect($route) 
	{
		global $router;

		header('Location: '. $router->generate($route));
	}
}