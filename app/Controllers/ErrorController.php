<?php

namespace Ebook\Controllers;

class ErrorController extends CoreController
{
    // gestion des erreurs 404
    public function error404() {
        $this->show('404');
    }

    // gestion des erreurs 401
    public function error401() {
        $this->show('401');
    }


}