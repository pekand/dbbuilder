<?php

class Autoloader {
    static public function loader($className) {

        $filename = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR. str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";

        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        } else {
            echo "Class not found! : ".$className;
            die();
        }
        return FALSE;
    }
}

spl_autoload_register('Autoloader::loader');
