<?php

namespace App\Controllers;

// Classe gérant l'erreur 404
class ErrorController extends CoreController {
    /**
     * Méthode gérant l'affichage de la page 404
     *
     * @return void
     */
    public function err404() 
    {
        // j'envoie le header 404
        header('HTTP/1.0 404 Not Found');

        // puis je gère l'affichage
        $this->show('error/err404');
    }

    /**
     * Méthode gérant l'affichage de la page 403
     *
     * @return void
     */
    public function err403()
    {
        // j'envoie le header 403
        http_response_code(403);

        // puis je gère l'affichage
        $this->show('error/err403');

        // j'empêche l'execution du code qui est à la suite
        die();
    }
}