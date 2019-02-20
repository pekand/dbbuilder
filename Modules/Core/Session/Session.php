<?php

namespace Core\Session;

class Session {
	public function __construct() {
        $this->start();
    }

	public function start() {
        if (session_status() === PHP_SESSION_NONE) {
        	session_start();
        }
    }

    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function set($name, $value) {
    	$_SESSION[$name] = $value;
        return $this;
    }

    public function remove() {
    	session_unset(); 
        return null;
    }

    public function close() {
        $this->remove();
    	session_destroy();
        return null;
    }

    public function list() {
        return $_SESSION;
    }
}