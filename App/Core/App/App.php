<?php

namespace Core\App;

use Core\Router\Router;
use Core\Services\ServicesContainer;

class App {
    public $config = null;
    public $router = null;
    public $services = null;

    public function __construct() {

    }

    public function init() {
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
