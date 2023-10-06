<?php

// namespace sert à définir un "chemin" vers la classe
namespace Ebook\utils;

// pour utiliser la classe native PDO de PHP, on doit ajouter use PDO !
use PDO;

// Retenir son utilisation  => Database::getPDO()
// Design Pattern : Singleton
class Database
{
    /** @var PDO */
    private $dbh;
    private static $_instance;
    private function __construct()
    {
        // Récupération des données du fichier de config
        // la fonction parse_ini_file parse le fichier et retourne un array associatif
        $configData = parse_ini_file(__DIR__ . '/../config.ini');


        // le bloc try/catch -> gestion d'erreurs
        // try {
        // on essaye quelque chose
        // et si ce quelque chose déclenche une erreur PHP
        // } catch(Exception $exception) {
        // on "intercepte" cette erreur
        // -> le script PHP va se poursuivre, l'erreur ne va pas bloquer l'exec

        // on peut ici par exemple afficher un popup d'erreur à l'utilisateur
        // }

        // on essaye de se connecter à la BDD
        try {
            $this->dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
            );
        } catch (\Exception $exception) {
            // si la connexion fonctionne pas, on fait ça :
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage() . '<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    }
    // the unique method you need to use
    public static function getPDO()
    {
        // If no instance => create one
        if (empty(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance->dbh;
    }
}