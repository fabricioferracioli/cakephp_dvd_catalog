<?php

/**
 * Formats Controller
 *
 * file: /app/controllers/formats_controller.php
 */
class FormatsController extends AppController {
	// good practice to include the name variable
	var $name = 'Formats';
	
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
	 * main index page of the formats page
	 * url: /formats/index
	 */
	function index() {
		// this tells cake to ignore related format data such as dvds
		$this->Format->recursive = 0;
	
		// get all formats from database where status = 1
		$formats = $this->Format->findAll("status=1");
	
		// save the formats in a variable for the view
		$this->set('formats', $formats);
	}
	
	/**
	 * view()
	 * displays a single format and all related dvds
	 * url: /formats/view/format_slug
	 */
	function view($slug = null) {
		// if slug is null
		if(!$slug) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Format', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
		
		// find format in database
		$format = $this->Format->findBySlug($slug);
		
		// if format has been found
		if(!empty($format)) {
			// set the format for the view
			$this->set('format', $format);
		} else {
			// set a flash message
			$this->Session->setFlash('Invalid id for Format', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
	}

	/**
	 * admin_index()
	 * main index for admin users
	 * url: /admin/formats/index
	 */
	function admin_index() {
		// this tells cake to ignore related format data such as dvds
		$this->Format->recursive = 0;
	
		// get all formats from database where status = 1
		$formats = $this->Format->findAll("status=1");
	
		// save the formats in a variable for the view
		$this->set('formats', $formats);
	}

	/**
	 * admin_add()
	 * allows an admin to add a format
	 * url: /admin/formats/add
	 */
	function admin_add() {
		// if the form data is not empty
		if (!empty($this->data)) {
			// initialise the format model
			$this->Format->create();
	
			// create the slug
			$this->data['Format']['slug'] = $this->slug($this->data['Format']['name']);
	
			// try saving the format
			if ($this->Format->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Format has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Format could not be saved. Please, try again.', 'flash_bad');
			}
		}
	}

	/**
	* admin_edit()
	* allows an admin to edit a format
	* url: /admin/formats/edit/1
	*/
	function admin_edit($id = null) {
		// if the id is null and the form data empty
		if (!$id && empty($this->data)) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Format', 'flash_bad');
			// redirect the user
			$this->redirect(array('action'=>'index'));
		}
		
		// if the form data is empty
		if (!empty($this->data)) {
			// create the slug
			$this->data['Format']['slug'] = $this->slug($this->data['Format']['name']);
		
			// try saving the form data
			if ($this->Format->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Format has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Format could not be saved. Please, try again.', 'flash_bad');
			}
		}
		
		// if form has not been submitted
		if (empty($this->data)) {
			// find the format from the database and populate the form data
			$this->data = $this->Format->read(null, $id);
		}
	}

	/**
	 * admin_delete()
	 * allows an admin to delete a format
	 * url: /admin/formats/delete/1
	 */
	function admin_delete($id = null) {
		// if the id is null
		if (!$id) {
			// set flash message
			$this->Session->setFlash('Invalid id for Format', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

		// set the id of the format
		$this->Format->id = $id;

		// try to change status from 1 to 0
		if ($this->Format->saveField('status', 0)) {
			// set flash message
			$this->Session->setFlash('The Format was successfully deleted.', 'flash_good');
		} else {
			// set flash message
			$this->Session->setFlash('The Format could not be deleted. Please try again.', 'flash_bad');
		}
		
		// redirect
		$this->redirect(array('action'=>'index'));
	}

}
?>