<?php

/**
* @PSR PSR-0, PSR-1, PSR-2, PSR-3 , PSR-4 (partial)
*/
require_once("bin/config.php");

class Autoloader {

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    private static function autoload($class)
    {
        $parts = preg_split("#\\\#", $class);
        $className = array_pop($parts);
        require_once ROOT.strtolower(implode(DS, $parts)).DS.$className.'.php';
    }
}
