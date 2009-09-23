<?php

/**
 * Locations Controller
 *
 * file: /app/controllers/locations_controller.php
 */
class LocationsController extends AppController {
	// good practice to include the name variable
	var $name = 'Locations';
	
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
	 * main index page of the locations page
	 * url: /Locations/index
	 */
	function index() {
		// this tells cake to ignore related Location data such as dvds
		$this->Location->recursive = 0;
	
		// get all locations from database where status = 1
		$locations = $this->Location->findAll("status=1");
	
		// save the locations in a variable for the view
		$this->set('locations', $locations);
	}
	
	/**
	 * view()
	 * displays a single location and all related dvds
	 * url: /location/view/location_slug
	 */
	function view($slug = null) {
		// if slug is null
		if(!$slug) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Location', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
		
		// find location in database
		$location = $this->Location->findBySlug($slug);
		
		// if location has been found
		if(!empty($location)) {
			// set the location for the view
			$this->set('location', $location);
		} else {
			// set a flash message
			$this->Session->setFlash('Invalid id for Location', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}
	}

	/**
	 * admin_index()
	 * main index for admin users
	 * url: /admin/locations/index
	 */
	function admin_index() {
		// this tells cake to ignore related Location data such as dvds
		$this->Location->recursive = 0;
	
		// get all locations from database where status = 1
		$locations = $this->Location->findAll("status=1");
	
		// save the locations in a variable for the view
		$this->set('locations', $locations);
	}

	/**
	 * admin_add()
	 * allows an admin to add a locations
	 * url: /admin/locations/add
	 */
	function admin_add() {
		// if the form data is not empty
		if (!empty($this->data)) {
			// initialise the location model
			$this->Location->create();
	
			// create the slug
			$this->data['Location']['slug'] = $this->slug($this->data['Location']['name']);
	
			// try saving the Location
			if ($this->Location->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Location has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Location could not be saved. Please, try again.', 'flash_bad');
			}
		}
	}

	/**
	* admin_edit()
	* allows an admin to edit a location
	* url: /admin/locations/edit/1
	*/
	function admin_edit($id = null) {
		// if the id is null and the form data empty
		if (!$id && empty($this->data)) {
			// set a flash message
			$this->Session->setFlash('Invalid id for Location', 'flash_bad');
			// redirect the user
			$this->redirect(array('action'=>'index'));
		}
		
		// if the form data is empty
		if (!empty($this->data)) {
			// create the slug
			$this->data['Location']['slug'] = $this->slug($this->data['Location']['name']);
		
			// try saving the form data
			if ($this->Location->save($this->data)) {
				// set a flash message
				$this->Session->setFlash('The Location has been saved', 'flash_good');
				// redirect
				$this->redirect(array('action'=>'index'));
			} else {
				// set a flash message
				$this->Session->setFlash('The Location could not be saved. Please, try again.', 'flash_bad');
			}
		}
		
		// if form has not been submitted
		if (empty($this->data)) {
			// find the location from the database and populate the form data
			$this->data = $this->Location->read(null, $id);
		}
	}

	/**
	 * admin_delete()
	 * allows an admin to delete a Location
	 * url: /admin/Locations/delete/1
	 */
	function admin_delete($id = null) {
		// if the id is null
		if (!$id) {
			// set flash message
			$this->Session->setFlash('Invalid id for Location', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

		// set the id of the location
		$this->Location->id = $id;

		// try to change status from 1 to 0
		if ($this->Location->saveField('status', 0)) {
			// set flash message
			$this->Session->setFlash('The Location was successfully deleted.', 'flash_good');
		} else {
			// set flash message
			$this->Session->setFlash('The Location could not be deleted. Please try again.', 'flash_bad');
		}
		
		// redirect
		$this->redirect(array('action'=>'index'));
	}

}
?>