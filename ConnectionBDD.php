<?php

/**
 * Gère les interactions avec la base de données.
 */
class DataBase
{
    
    protected static $config = [
        'hostname' => 'localhost',
        'database' => 'id16089884_bddjeuxdemots',
        'user' => 'id16089884_bddjeuxdemots2021',
        'password' => '@Terjeuxdemots2021'
    ];

    //private static PDO $inst=new PDO("mysql:host=".self::$config["hostname"]. ";dbname=" . self::$config["database"], self::$config["user"], self::$config["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        

    /**
     * Ouvre une connection avec la base de donnée et renvoie le résultat.
     */
    public static function getInstance()
    {
    
        $inst= new PDO("mysql:host=".self::$config["hostname"]. ";dbname=" . self::$config["database"], self::$config["user"], self::$config["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        return $inst;
    }

    /**
     * Lance une requête en base et retourne le résultat.
     */
    public static function launchQuery($db, $query)
    {

        $s = $db->prepare($query);
        $s->execute();

        return $s;
    }
}
