<?php

class Autoloader {
    static public function loader($className) {

        try {
            $filename = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR. str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";

            if (file_exists($filename)) {
                require_once($filename);
                if (class_exists($className)) {
                    return true;
                }
            } else {
                dump("Class not found! : ".$className);
                dump(( new \Exception)->getTraceAsString());
                die();
            }
            return false;
        } catch(Exception $exception) {
            dump(exception);
        }
    }
}

spl_autoload_register('Autoloader::loader');
