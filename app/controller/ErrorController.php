<?php

namespace Ebook\controller;

class ErrorController extends CoreController
{
    public function error404()
    {
        $this->show('404');
    }

    public function error401()
    {
        $this->show('401');
    }
}

