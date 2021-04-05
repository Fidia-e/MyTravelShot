<?php

namespace App\Controllers;

use App\Models\Shot;

class ShotController extends CoreController {

    /**
     * Affiche la photos en fonction des auteurs
     */
    
    public function browseByAuthor($author_id)
    { 
        $datas = Shot::findByAuthorId($author_id);
        $viewVars = ['shotByAuthor' => $datas];
        // dd($datas);

        $this->show('authors-shots', $viewVars);
    }

}