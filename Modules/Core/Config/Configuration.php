<?php

namespace Core\Config;

class Configuration
{
    private $app = null;
    private $config = [];
    
    public function __construct($app) {
        $this->app = $app;
    }
    
    public function add($name, $callback=null) {
        
        $config = [
            'name' => $name,
            'callback' => $callback,
            'value' => null,
        ];

        $this->config[$name] = $config;
    }
    
    public function set($name, $value) {
        
        $config = [
            'name' => $name,
            'callback' => null,
            'value' => $value,
        ];

        $this->config[$name] = $config;
    }
    
    public function get($name) {
        if(!isset(($this->config[$name]))) {
            return null;
        }

        if(!empty($this->config[$name]['value'])) {
            return $this->config[$name]['value'];
        }

        if(empty($this->services[$name]['callback'])) {
            return null;
        }

        $result = call_user_func_array($this->services[$name]['callback'], [$this->app]);

        $this->services[$name]['value'] = $result;

        return $this->services[$name]['value'];
    }
    
    public function load() {
        $app = $this->app;
        $config = $this;

        foreach ($app->getModulesPaths()  as $module) {
            $path = $module . '/Config/*Config.php';

            foreach (glob($path) as $configFile) {
                include $configFile;
            }
        }        
    }
}