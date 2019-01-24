<?php

    namespace Core\Auth;

    class Auth {
        private $session = null;
        private $userManager = null;
        private $currentUsers = null;
        private $users = array();

        public function __construct($session, $userManager) {
            $this->session = $session;
            $this->userManager = $userManager;
        }

        public function login($username, $password) {
            $user = $this->findUser($username);

            if ($user == null) {                
                return false;
            }

            if (!password_verify($password, $user['password'])) {
                return false;
            }
            
            $this->setCurrentUser($user);

            return true;
        }

        public function logout() {            
            $this->currentUsers = null;
            $this->session->close();
        }

        public function findUser($username) {           
            return $this->userManager->get($username);
        }

        private function setCurrentUser($user) {
            $user = array(
                'username' => $user['username'],
                'roles' => explode(',',$user['roles']),
                'rights' => explode(',',$user['rights']),
            );

            $this->session->set("user", $user);

            $this->currentUsers = $user;
        }

        public  function getUser() {
            if (!empty($this->currentUsers)) {
                return $this->currentUsers;
            }
            
            $user = $this->session->get("user");

            if(empty($user)) {
                return null;
            }
            
            $this->currentUsers = $user;

            return $this->currentUsers;
        }

        public function createUser($username, $password, $roles = array(), $rights = array()) {
            $this->userManager->create($username, password_hash($password, PASSWORD_DEFAULT), $roles, $rights);
        }

        public function is($role) {
            $user = $this->getUser();

            if (!empty($user) && in_array($role, $user['roles'])) {
                return true;
            }

            return false;
        }
        
        public function has($right) {
            $user = $this->getUser();
            if (!empty($user) && in_array($right, $user['rights'])) {
                return true;
            }

            return false;
        }
        
        public function addRole($usernamen, $role) {
            
            if(!$this->is('admin')) {
                return;
            }
                       
            //todo
            
            return;
        }
        
        public function addRight($usernamen, $right) {
            
            if(!$this->is('admin')) {
                return;
            }
                       
            //todo
            
            return;
        }
    }
