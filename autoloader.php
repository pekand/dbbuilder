<?php

class Autoloader {
    static public function loader($className) {

        $filename = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR. str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";

        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return true;
            }
        } else {
            echo "Class not found! : ".$className;
            var_dump(( new \Exception)->getTraceAsString());
            die();
        }
        return false;
    }
}

spl_autoload_register('Autoloader::loader');
