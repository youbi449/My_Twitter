<?php
class Connexion
{
    protected $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new PDO('mysql:dbname=common_database;host=localhost', 'root', '');
        } catch (Exception $e) {
            die('Connexion échoué :' . $e->getMessage());
        }
    }

    public function getDB()
    {
        return $this->bdd;
        // var_dump($this->bdd);
    }
}
