<?php

/**
 * Users Controller
 *
 * file: /app/controllers/userss_controller.php
 */
class UsersController extends AppController {
	// name variable
	var $name = 'Users';

	// load any helpers used in the views
	var $helpers = array('Html', 'Form');

	/**
	 * index()
	 * main page for users
	 * url: /users/index
	 */
	function index() {
		// redirect to login page
		$this->redirect('login');
	}

	/**
	 * index()
	 * main index page for login
	 * url: /users/login
	 */
	function login() {
		// if the form has been submitted
		if(!empty($this->data)) {
			// check the username and password
			if( ($user = $this->User->check_login($this->data)) ) {
				// save the user information to the session
				$this->Session->write('User', $user);
				// set flash messsage
				$this->Session->setFlash('You have successfully logged in.', 'flash_good');
				// redirect the user
				$this->redirect('/admin/dvds/');
			} else {
				// set error message
				$this->set('error', 'ERROR: Invalid Username or Password.');
			}
		}
	}

	/**
	 * logout()
	 * logs out a user
	 * url: /users/logout
	 */
	function logout() {
		// delete the User session
		$this->Session->delete('User');
		// set flash message
        $this->Session->setFlash('You have successfully logged out.', 'flash_good');
		// redirect the user
        $this->redirect(array('action'=>'login', 'controller'=>'users')); 
	}
}
?>