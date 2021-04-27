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
    /**
     * Méthode dite "constructeur" qui sera appelée à chaque fois
     * que la class CoreController sera héritée
     *
     * @param [] $route
     */
    public function __construct($route = [])
   {
    // définition du tableau (ACL) contenant les routes 
    // qui sont resteintes pour certains rôles
    // Comment ça fonctionne :
    //      1- si la route n'est pas dans la liste, alors elle est accessible à tous (hors connexion)
    //      2- [] => il faut être connecté pour y avoir accès
    //      3- les rôles listés dans le tableaux ont accès à la route correspondante
        $accessControlList = [
           
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

        // je vérifie que la route courante est dans le tableau
        // qui liste les routes restreintes
        if($route && array_key_exists($route, $accessControlList)) {

            // je récupère les rôles autorisés par la route de l'ACL et
            // j'appelle la fonction de vérification en lui passant les rôles en argument
            $authorizedRoles = $accessControlList[$route];
            $this->checkAuthorization($authorizedRoles);
        }

        // création d'un tableau contenant les routes potentiellement dangereuses 
        // qui seront protégées par un token CSRF
        $csrfRoutes = [
            'post' => [
                'shot-create',
                'shot-update',
                'author-create',
                'author-update',
                'user-create',
                'user-update',
                'user-updateprofil',
            ],
            'get' => [
                'shot-delete',
                'author-delete',
                'user-delete',
            ]
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
		require __DIR__ . '/../Views/header.tpl.php';
		require __DIR__ . '/../Views/' . $viewName . '.tpl.php';
        require __DIR__ . '/../Views/footer.tpl.php';
	}

    /**
     * Méthode permettant de rediriger l'utilisateur, dans tous les controllers
     */
     public function redirect($route) 
    {
        global $router;

        // la fonction header() renvoie une redirection au navigateur
        // avec un type d'appel spécial "location" et un code 302 (redirection)
        header('Location: '. $router->generate($route));
    }

    /**
     * Méthode permettant de vérifier les droits d'accès à une page
     *
     * @param array $roles
     */
    public function checkAuthorization($roles = [])
    {
        // je vérifie que l'utilisateur est bien connecté
        if(isset($_SESSION['currentUser'])) {
            // je récupère l'utilisateur de la session
            $userRole = $_SESSION['currentUser']->getRole();

            // je vérifie l'une des deux conditions suivantes:
            // si le rôle de l'utilisateur n'est pas dans le tableau de rôles ($roles) 
            // et que la liste des rôles n'est pas vide
            if(!in_array($userRole, $roles) && !empty($roles)){
                
                // j'instancie le controller d'erreurs et j'affiche la vue pour l'erreur 403
                $errorController = new ErrorController;
                $errorController->err403();
            }

        } else {
            // si l'utilisateur n'est pas connecté
            // je le redirige vers la page de connexion
            $this->redirect('admin-login');
        }
    }

    /**
     * Méthode permettant de générer un token aléatoire pour prévenir les attaques CSRF
	 * ce token sera stocké en session et renvoyé afin d'être placé 
     * dans les formulaires et routes à protéger
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
     * Méthode vérifiant que le token passé dans le formulaire 
     * correspond bien à celui stocké en session
     * en fonction de la méthode effectuée
     */
     protected function checkCsrfToken($method)
    {
        if($method == 'post') {
            // je récupère le token du formulaire en POST
            $token = filter_input(INPUT_POST, 'token');
        } else if ($method == 'get') {
            // je récupère le token du formulaire en GET
            $token = filter_input(INPUT_GET, 'token');
        }

        // je récupère le token de la session
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