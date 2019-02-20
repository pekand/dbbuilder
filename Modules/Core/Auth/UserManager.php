<?php

namespace Core\Auth;

class UserManager {
	private $db = null;

	public function __construct($db) {
        $this->db = $db;
    }

	public function init() {

    }

	public function create($username, $password, $roles = [], $rights = []) {
		$this->db->exec(
			'INSERT INTO users (uid, username, password, roles, rights) VALUES (:uid, :username, :password, :roles, :rights)', 
			[ 
				"uid"=>$this->db->uid(), 
				"username" => $username, 
				"password"=> $password,
				"roles"=> implode(',',$roles),
				"rights"=> implode(',',$rights)
			]
		);
    }

	public function update($username, $password, $roles = [], $rights = []) {
        $this->db->exec(
			'UPDATE users SET password = :password, roles = :roles, rights = :rights WHERE username=:username;', 
			[ 
				"username" => $username,
				"password" => $password,
				"roles"=> implode(',',$roles),
				"rights"=> implode(',',$rights)
			]
		);
    }

    public function get($username) {
        $user =  $this->db->get(
			'SELECT * FROM users WHERE username=:username;', 
			[ 
				"username" => $username, 
			]
		);

		if (empty($user) || !is_array($user) || count($user) == 0) {
			return null;
		}

		return $user[0];
    }
    
    public function exists($username) {
       $user = $this->get($username);
       
       return $user !== null;
    }

    public function remove($username) {
        $this->db->exec(
			'DELETE FROM users WHERE username=:username;', 
			[ 
				"username" => $username, 
			]
		);
    }
}