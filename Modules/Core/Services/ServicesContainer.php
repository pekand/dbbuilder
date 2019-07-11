<?php

namespace Core\Services;

class ServicesContainer
{
    private $app = null;
    private $services = [];
    
    public function __construct($app) {
        $this->app = $app;
    }
    
    public function add($name, $callback=null) {
        
        $service = [
            'name' => $name,
            'callback' => $callback,
            'object' => null,
        ];

        $this->services[$name] = $service;
    }
    
    public function get($name) {
        if(!isset(($this->services[$name]))) {
            throw new Exception("Service '".$name."' not found");
            
        }

        if(!empty($this->services[$name]['object'])) {
            return $this->services[$name]['object'];
        }

        if(empty($this->services[$name]['callback'])) {
            throw new Exception("Service '".$name."' is not callable");
        }

        $result = call_user_func_array($this->services[$name]['callback'], [$this->app]);

        $this->services[$name]['object'] = $result;

        return $this->services[$name]['object'];
    }
    
    public function load() {
        $app = $this->app;
        $services = $this->app->services;

        foreach ($app->getModulesPaths() as $module) {
            $path = $module . '/Services/*Services.php';

            foreach (glob($path) as $servicesFile) {
                include $servicesFile;
            }
        }        
    }
}