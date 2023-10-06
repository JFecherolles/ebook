<?php

namespace Ebook\controller;
use Ebook\controller\CoreController;
use Ebook\utils\Database;
use Ebook\model\Livres;

class LivreController extends CoreController
{
    public function update()
    {
        $id = $_POST['id'];
        $auteurNom = $_POST['auteurNom'];
        $auteurPrenom = $_POST['auteurPrenom'];
        $titre = $_POST['Titre'];

        $updateBook = Livres::find($id);

        $updateBook->setAuteurNom($auteurNom);
        $updateBook->setAuteurPrenom($auteurPrenom);
        $updateBook->setTitre($titre);
        
        $succes = $updateBook->update();

        $viewData['listLivre'] = Livres::findAll();

        $this->show('index', $viewData);
        //header('Location: index');

    }

    public function delete()
    {
        $id = $_POST['idlivre'];
        $delete = Livres::find($id);

        $delete->delete();

        header('Location:'.$_SERVER['BASE_URI'].'/');
    }

}