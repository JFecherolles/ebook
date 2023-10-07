<?php

namespace Ebook\Models;

use PDO;
use Ebook\utils\Database;

class AppUser 
{
    private $id;

     /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string $email AppUser email
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    public static function find(int $id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // dans la mesure où $id est de type int, on ne pourra pas injecter de code ici
        // donc pas de requête préparée ? par sécurité on pourrait le faire...
        // écrire notre requête
        $sql = 'SELECT * FROM `user` WHERE `id` =' . $id;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $appUser = $pdoStatement->fetchObject('Ebook\Models\AppUser');

        // retourner le résultat
        return $appUser;
    }

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'Ebook\Models\AppUser');

        return $results;
    }

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `user` (email, password)
            VALUES (:email, :password);
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);

        $pdoStatement->execute();

        if ($pdoStatement->rowCount() > 0) {
            $this->id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
               UPDATE `user`

               SET email = :email,
               password = :password

               WHERE id = :id;
               ";

        // Execution de la requête de mise à jour (exec, pas query)
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);

        $success = $pdoStatement->execute();

        // retourne si échec ou réussite de la requête
        return $success;
    }

    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `user`
            WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $success = $pdoStatement->execute();

        return $success;
    }

    /**
     * Pour l'étape 4
     * Récupérer un user via son e-mail
     */
    public static function findByEmail(string $email)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        // /!\ c'est une requête "préparée" puisqu'on reçoit une donnée utilisateur
        // et que l'on souhaite se protéger des injections SQL
        $sql = '
        SELECT *
        FROM user
        WHERE email = :email';

        // on prépare notre requête
        $pdoStatement = $pdo->prepare($sql);

        // on associe les valeurs
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);

        // on exécute la requête
        $pdoStatement->execute();

        // on récupère un seul résultat => fetchObject
        $appUser = $pdoStatement->fetchObject('Ebook\Models\AppUser');

        // retourner le résultat
        return $appUser;
    }

    /**
     * Get $email AppUser email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set $email AppUser email
     *
     * @param  string  $email  $email AppUser email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

}