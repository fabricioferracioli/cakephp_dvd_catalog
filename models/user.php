<?php

/**
 * file: app/model/user.php
 *
 * User Model
 */
class User extends AppModel {
	var $name = 'User';
	var $useTable = 'admins';

	/**
	 * check_login()
	 * checks the username and password against the database
	 */
	function check_login($data) {
		// init
		$valid = false;
		
		// find user from the database with the username
		$user = $this->find('first', array(
			'conditions' => array(
				'User.username'=>$data['User']['username']
			)
		));
		
		// if the passwords match
		if($user['User']['password'] == md5($data['User']['password'])) {
			$valid = $user;
		}
		
	return $valid;
	}
}

?>