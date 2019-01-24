<?php

namespace Core\Auth;

class UserManager {
	private $db = null;

	public function __construct($db) {
        $this->db = $db;
    }

	public function init() {
        $this->db->drop('users');
		$this->db->create('users');
		$this->db->addColumn('users', 'uid', 'CHAR(255)', 'not null default ""');
		$this->db->addColumn('users', 'username', 'CHAR(255)', '');
		$this->db->addColumn('users', 'password', 'CHAR(255)', '');
		$this->db->addColumn('users', 'roles', 'CHAR(255)', '');
		$this->db->addColumn('users', 'rights', 'CHAR(255)', '');
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

    public function remove($username) {
        $this->db->exec(
			'DELETE FROM users WHERE username=:username;', 
			[ 
				"username" => $username, 
			]
		);
    }
}