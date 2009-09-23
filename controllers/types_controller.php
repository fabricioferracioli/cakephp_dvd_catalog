<?php

/**
 * Types Controller
 *
 * file: /app/controllers/types_controller.php
 */
class TypesController extends AppController {
	// good practice to include the name variable
	var $name = 'Types';
	
	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');

	/**
	 * beforeFilter()
	 * this is called before any action in the controller
	 */
	function beforeFilter() {
		// if an admin action has been called
		if(isset($this->params['admin']) && $this->params['admin']) {
			// check that a user is logged in
			$this->check_user();
		}
	}

	/**
	 * index()
	 * main index page of the types page
	 * url: /types/index
	 */
	function index() {
		// this tells cake to ignore related type data such as dvds
		$this->Type->recursive = 1;
	
		// get all types from database where status = 1
		$types = $this->Type->findAll("status=1");
	
		// save the types in a variable for the view
		$this->set('types', $types);
	}

	/**
	 * view()
	 * displays a single Type and all related dvds
	 * url: /types/view/type_slug
	 */
	function view($slug = null) {
		// if slug is null
		if(!$slug) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Type', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
		
		// find Type in database
		$type = $this->Type->findBySlug($slug);
		
		// if Type has been found
		if(!empty($type)) {
			// set the Type for the view
			$this->set('type', $type);
		} else {
			// set a flash message
			$this->Session->setFlash('Invalid id for Type', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
	}

	/**
	 * admin_index()
	 * main index for admin users
	 * url: /admin/types/index
	 */
	function admin_index() {
		// this tells cake to ignore related Type data such as dvds
		$this->Type->recursive = 0;
	
		// get all types from database where status = 1
		$types = $this->Type->findAll("status=1");
	
		// save the Types in a variable for the view
		$this->set('types', $types);
	}

	/**
	 * admin_add()
	 * allows an admin to add a type
	 * url: /admin/types/add
	 */
	function admin_add() {
		// if the form data is not empty
		if (!empty($this->data)) {
			// initialise the Type model
			$this->Type->create();
	
			// create the slug
			$this->data['Type']['slug'] = $this->slug($this->data['Type']['name']);
	
			// try saving the Type
			if ($this->Type->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Type has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Type could not be saved. Please, try again.', 'flash_bad');
			}
		}
	}

	/**
	* admin_edit()
	* allows an admin to edit a type
	* url: /admin/types/edit/1
	*/
	function admin_edit($id = null) {
		// if the id is null and the form data empty
		if (!$id && empty($this->data)) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Type', 'flash_bad');
			// redirect the user
			$this->redirect(array('action'=>'index'));
		}
		
		// if the form data is empty
		if (!empty($this->data)) {
			// create the slug
			$this->data['Type']['slug'] = $this->slug($this->data['Type']['name']);
		
			// try saving the form data
			if ($this->Type->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Type has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Type could not be saved. Please, try again.', 'flash_bad');
			}
		}
		
		// if form has not been submitted
		if (empty($this->data)) {
			// find the Type from the database and populate the form data
			$this->data = $this->Type->read(null, $id);
		}
	}

	/**
	 * admin_delete()
	 * allows an admin to delete a Type
	 * url: /admin/Types/delete/1
	 */
	function admin_delete($id = null) {
		// if the id is null
		if (!$id) {
			// set flash message
			$this->Session->setFlash('Invalid id for Type', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

		// set the id of the Type
		$this->Type->id = $id;

		// try to change status from 1 to 0
		if ($this->Type->saveField('status', 0)) {
			// set flash message
			$this->Session->setFlash('The Type was successfully deleted.', 'flash_good');
		} else {
			// set flash message
			$this->Session->setFlash('The Type could not be deleted. Please try again.', 'flash_bad');
		}
		
		// redirect
		$this->redirect(array('action'=>'index'));
	}

}
?>