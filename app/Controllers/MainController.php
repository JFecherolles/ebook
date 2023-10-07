<?php

namespace Ebook\Controllers;

use Ebook\Models\Livres;

class MainController extends CoreController
{
    
    public function home() {
        
        $livresMod = new Livres();
        $affLivres = $livresMod->findAll();


        $this->show('index', ['listLivre' => $affLivres]);

    }


}

?>