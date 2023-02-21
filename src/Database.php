<?php
class Database
{
    private static ?self $instance = null;

    private PDO $PDOInstance;

    /**
     * Classe Singleton
     * Constructeur privé Database
     */
    private function __construct()
    {
        $this->PDOInstance = new PDO('mysql:dbname=chatpoT;host=localhost', 'root', '');
        $this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        $this->PDOInstance->query('SET NAMES utf8');
        $this->PDOInstance->query('SET CHARACTER SET utf8');
    }

    /**
     * Récupère une instance de Database (Singleton)
     * @return Database static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Récupère l'objet PDO de PHP
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->PDOInstance;
    }


}