<?php

/**
 * Ajoute des méthodes pour naviguer entre les fichiers.
 */
class FileHelper {
    
    /**
     * Crée le chemin demandé. 
     */
    public static function buildPath($pathArray)
    {
        $directorySeparator = DIRECTORY_SEPARATOR;
        $rootFolder = __DIR__ . $directorySeparator . "..";
        return $rootFolder . $directorySeparator . join($directorySeparator, $pathArray);
    }

    /**
     * récupère l'url de base de l'application.
     */
    public static function getBaseURL()
    {
        $currentPath = $_SERVER['PHP_SELF'];
        $pathInfo = pathinfo($currentPath);
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
        return $protocol . $hostName . "/";
    }
}

?>