<?php

namespace Ebook\Controllers;

use Ebook\Models\AppUser;

class UserController extends CoreController
{
    /**
     * Displays login form
     */
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Connect user
     */
    public function connect()
    {
        // on récupère l'e-mail et le mot de passe qui vient du form
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // - on va chercher le user via son identifiant
        $appUser = AppUser::findByEmail($email);
        // on récupère l'e-mail et le mot de passe qui vient du form
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // - on va chercher le user via son identifiant
        $appUser = AppUser::findByEmail($email);
        // dump($appUser);

        
        // 0fe20a92de57999bfacc69eb5a0c4f7776d816f659e4c6199842a43c24de939c

        // - cas 1 : user non trouvé => erreur sur le form
        if ($appUser === false) {
            echo 'Utilisateur non trouvé.';
        } else {
            // - cas 2 : user trouvé :tada:
            // - on vérifie que le mot de passe fourni correspond au mot de passe récupéré depuis la base
            // - avec password_hash, on hache le mot de passe avec l'algo BCRYPT
            // - avec password_verify(), on demande à l'algo BCRYPT de nous dire si les mots de passe correspond
            if (false === password_verify($password, $appUser->getPassword())) {
                //     - cas 1 : ne correspond pas => erreur sur le form
                echo 'Le mot de passe ne correspond pas.';
            } else {
                // - cas 2 : correspond !
                // - on le "connecte" au serveur via la session
                // "userId" : l'id de l'utilisateur connecté
                $_SESSION['userId'] = $appUser->getId();
                // "userObject" : l'objet AppUser de l'utilisateur connecté
                $_SESSION['userObject'] = $appUser;
                // - on va échanger un cookie de session entre le client et le serveur
                // - on redirige vers la home
                header('Location:' . $_SERVER['BASE_URI'] . '/livres');
                exit;
            }
        }
    }

    /**
     * Déconnexion/Logout
     */
    public function logout()
    {
        // unset() permet de supprimer une variable ou un index ou une clé de tableau
        // @see https://www.php.net/manual/en/function.unset
        // on "supprime" les clés de la session liées à ntre utilisateur
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        // redirection vers le login
        global $router;
        header('Location: ' . $router->generate('user-login'));
        exit;
    }

    /**
     * Liste des utilisateurs
     */
    public function list()
    {
        // nos utilisateurs
        $users = AppUser::findAll();
        // dd($users);

        // on génère la vue
        $this->show('user/list', [
            'users' => $users,
        ]);
    }

    /**
     * Ajout d'un utilisateur (affichage du form en GET)
     */
    public function add()
    {
        // on crée un objet dont les propriétés sont vides
        $user = new AppUser();
        // dump($user);

        // on génère la vue
        $this->show('user/add', [
            'user' => $user,
        ]);
    }

    /**
     * Traitement ajout catégorie en POST (le C du CRUD)
     */
    public function create()
    {
        // dd($_POST);

        // on récupère les données dans des variables
        // on utilise l'opérateur de coalescence nulle ??
        // https://www.php.net/manual/en/migration70.new-features.php
        // cet opérateur nous permet de mettre la valeur de $_POST['name'] dans $name s'il est défini, sinon ''
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // on créé un nouvel objet User prêt à être sauvegardé
        $user = new AppUser();
        // dump($category);

        // on alimente cet objet avec les donneés de la requête (on remplit ses propriétés)
        $user->setEmail($email);
        $user->setPassword($password);
        // dd($user);

        // VALIDATION DES DONNÉES
        // @see https://github.com/O-clock-Nazca/S06-E02-atelier-ajout-DB/blob/master/mega_bonus.md

        // on créé un tableau pour y ajouter les erreurs éventuelles
        $errorList = [];

        // l'adresse mail doit être valide
        // @see https://www.php.net/manual/en/function.filter-var.php
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorList[] = "L'adresse email n'est pas valide.";
        }

        // on vérifier que l'adresse e-mail n'est pas déjà présente dans la base
        // => si AppUser::findByEmail() vaut autre chose que "false", il existe
        if (AppUser::findByEmail($email) !== false) {
            $errorList[] = "Cette adresse mail existe déjà dans la base.";
        }

        // le mot de passe ne doit pas être vide
        if (empty($password)) {
            $errorList[] = "Le mot de passe est requis.";
        }

        // mot de passe "compliqué" voir les regex
        // https://regexone.com/
        // https://regexcrossword.com/
        // https://regex101.com/
        if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $password)) {
            $errorList[] = "Le mot de passe doit contenir les caractères démandés.";
        }

        // on vérifie si on a rencontré une erreur ou non
        if (empty($errorList)) {
            // si le tableau errorList est vide, ça veut dire qu'il n'y a pas d'erreur
            // donc on peut ajouter à la DB !

            // on hâche le mot de passe reçu avec l'algo bcrypt
            // juste avant de le sauvegarder
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);

            // on dit à cet objet de s'insérer dans la base !
            // save() renvoit true si l'ajout a fonctionné, false sinon
            $success = $user->insert();
            // dump($category);

            if ($success) {
                // @see https://www.php.net/manual/fr/function.header.php
                // on va utiliser le mot-clé "global" pour accéder au routeur
                // car on préfère générer la route que de l'écrire en dur
                // @todo trouver une solution plus orientée POO pour accéder à ce routeur
                // /!\ ne pas afficher quoique ce soit avant (echo, dump(), etc.)
                header('Location:' . $_SERVER['BASE_URI'] . '/livres');
                exit;
            } else {
                // ça n'a pas fonctionné, on met un message d'erreur, et le script continue après le if
                $errorList[] = "Erreur lors de l'ajout.";
                // si on arrive là, c'est qu'il y a eu une erreur
                // on réaffiche le formulaire, mais pré-rempli avec les (mauvaises) données saisies dans $_POST

                // on affiche à nouveau de form d'ajout, mais avec les erreurs & les données erronées
                $this->show('user/add', [
                    'errorList' => $errorList,
                    // le form attends un objet pour pré-remplir ses valeurs
                    'user' => $user,
                ]);
            }
        }
    }
}
