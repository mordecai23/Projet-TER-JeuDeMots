<?php 



/**

 * Gère les interactions avec la base de données.

 */

class DataBase {

    protected static $config = [

        'hostname' => 'localhost',

        'database' => 'id16089884_bddjeuxdemots', 

        'user' => 'root',

        'password' => ''

    ];

     

    /**

     * Ouvre une connection avec la base de donnée et renvoie le résultat.

     */

    public static function getInstance() {

        $pdo =new PDO("mysql:host=".self::$config["hostname"]. ";dbname=" . self::$config["database"], self::$config["user"], self::$config["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        return $pdo;
    }



    /**

     * Lance une requête en base et retourne le résultat.

     */

    public static function launchQuery($db, $query) {

            

        $s = $db->prepare($query);

        $s->execute();



        return $s;

    }

}



?>