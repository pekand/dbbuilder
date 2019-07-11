<?php

namespace Core\App;

use Core\Config\Configuration;
use Core\Router\Router;
use Core\Services\ServicesContainer;

class App {
    private $modulePaths = null;

    public $config = null;
    public $router = null;
    public $services = null;

    public function __construct() {

    }

    public function findModulesPaths($path = ROOT_PATH) {
        $paths = [];

        foreach (array_filter(glob($path . '/Modules/*'), 'is_dir') as $module) {

            $paths[] = $module;

            $subModules = $module . '/Modules/';

            if (file_exists($subModules) && is_dir($subModules)) {
                $paths = array_merge($paths, $this->findModulesPaths($module));
            }
        }

        return $paths;
    }

    public function getModulesPaths() {

        if (empty($this->modulePaths))
            $this->modulePaths = $this->findModulesPaths();

        return  $this->modulePaths;
    }

    public function init() {
        $this->config = new Configuration($this);
        $this->config->load();
        
        $this->services = new ServicesContainer($this);
        $this->services->load();

        $this->router = new Router($this);
        $this->router->load();
        
        $this->router->execute();
    }
    
    public function get($name) {
        return $this->services->get($name);
    }

}
