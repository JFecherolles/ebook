<?php

namespace Ebook\Controllers;

use Ebook\Models\Livres;

class MainController extends CoreController
{
    
    public function home() {
        
        
        $this->show('index');

    }

    public function livres() {
        
        $livresMod = new Livres();
        $affLivres = $livresMod->findAll();


        $this->show('livres', ['listLivre' => $affLivres]);

    }


}

?>