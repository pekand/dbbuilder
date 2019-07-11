<?php

class Autoloader {

    public static $modulePaths = null;

    public static function findModulesPaths($path = ROOT_PATH) {
        $paths = [];

        $modulesPath = $path . '/Modules';

        if (!file_exists($modulesPath) || !is_dir($modulesPath)) {
            return $paths;
        }

        $paths[] = $modulesPath; 

        foreach (array_filter(glob($modulesPath . '/*'), 'is_dir') as $module) {

            $paths = array_merge($paths, self::findModulesPaths($module));
        }

        return $paths;
    }

    public static function getModulesPaths() {

        if (empty(self::$modulePaths))
            self::$modulePaths = self::findModulesPaths();

        return  self::$modulePaths;
    }

    static public function loader($className) {
        $modulePaths = self::getModulesPaths();

        try {
            foreach ($modulePaths as $module) {
                $filename = $module.DIRECTORY_SEPARATOR. str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";

                if (file_exists($filename)) {
                    require_once($filename);
                    if (class_exists($className)) {
                        return true;
                    }
                } 
            }

            dump("Class not found! : ".$className);
            dump((new \Exception)->getTraceAsString());
            die();
        } catch(Exception $exception) {
            dump(exception);
        }
    }
}

spl_autoload_register('Autoloader::loader');
