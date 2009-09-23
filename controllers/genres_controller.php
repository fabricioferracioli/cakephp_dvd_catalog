<?php

/**
 * Genres Controller
 *
 * file: /app/controllers/genres_controller.php
 */
class GenresController extends AppController {
	// name variable
	var $name = 'Genres';

	// load helpers
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
	 * main index page for genres
	 * url: /genres/index
	 */
	function index() {
		// dont get related info
		$this->Genre->recursive = 0;
		// get genres from db and save for view
		$this->set('genres', $this->Genre->findAll("Genre.status=1", null, "Genre.name"));
	}

	/**
	 * view()
	 * displays a single genr and related dvds
	 * url: /genres/view/slug
	 */
	function view($slug = null) {
		// if slug is null
		if(!$slug) {
			// set a flash message
			$this->Session->setFlash('Invalid slug for Genre', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}

		// find genre in database
		$genre = $this->Genre->findBySlug($slug);

		// if genre has been found
		if(!empty($genre)) {
			// set the genre for the view
			$this->set('genre', $genre);
		} else {
			// set a flash message
			$this->Session->setFlash('Invalid slug for Genre', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}

		// set layout file
		$this->layout = 'view';
	}

	/**
	 * admin_index()
	 * main admin index page for genres
	 * url: /admin/genres/index
	 */
	function admin_index() {
		// dont get related info
		$this->Genre->recursive = 0;
		// get genres from db and save for view
		$this->set('genres', $this->Genre->findAll("Genre.status=1", null, "Genre.name"));
	}

	/**
	 * admin_add()
	 * allows an admin to add a genre 
	 * url: /admin/genres/add
	 */
	function admin_add() {
		// if the form data is not empty
		if (!empty($this->data)) {
			// initialise the Genre model
			$this->Genre->create();

			// create the slug
			$this->data['Genre']['slug'] = $this->slug($this->data['Genre']['name']);

			// check for a genre with the same slug
			$genre = $this->Genre->find('first', array(
				'conditions' => array(
					'Genre.slug'=>$this->data['Genre']['slug'],
					'Genre.status' => '1'
				)
			));

			// if slug is not taken
			if(empty($genre)) {
				// try saving the genre
				if ($this->Genre->save($this->data)) {
					// set a flash message
					$this->Session->setFlash('The Genre has been saved', 'flash_good');

					// redirect
					$this->redirect(array('action'=>'index'));
				} else {
					// set a flash message
					$this->Session->setFlash('The Genre could not be saved. Please, try again.', 'flash_bad');
				}
			} else {
				// set a flash message
				$this->Session->setFlash('The Genre could not be saved. The Name has already been taken.', 'flash_bad');
			}
		}
	}

	/**
	 * admin_edit()
	 * allows an admin to edit a genre
	 * url: /admin/genres/edit/id
	 */
	function admin_edit($id = null) {
		
		// find genre from db
		$genre = $this->_check_genre($id);
		
		// if the form data is not empty
		if (!empty($this->data)) {
			// initialise the Genre model
			$this->Genre->create();

			// create the slug
			$this->data['Genre']['slug'] = $this->slug($this->data['Genre']['name']);
			
			// check for a genre with the same slug
			$genre = $this->Genre->find('first', array(
				'conditions' => array(
					'Genre.slug'=>$this->data['Genre']['slug'],
					'Genre.status' => '1'
				)
			));

			// if slug is not taken
			if(empty($genre)) {
				// try saving the genre
				if ($this->Genre->save($this->data)) {
					// set a flash message
					$this->Session->setFlash('The Genre has been saved', 'flash_good');

					// redirect
					$this->redirect(array('action'=>'index'));
				} else {
					// set a flash message
					$this->Session->setFlash('The Genre could not be saved. Please, try again.', 'flash_bad');
				}
			} else {
				// set a flash message
				$this->Session->setFlash('The Genre could not be saved. The Name has already been taken.', 'flash_bad');
			}
		} else {
			// set genre for view
			$this->data = $genre;
		}
	}

	/**
	 * admin_delete()
	 * allow an admin to delete a genre
	 * url: admin/genres/delete/1
	 */
	function admin_delete($id = null) {
		// check genre is valid and exists
		$genre = $this->_check_genre($id);

		// set the id of the genre
		$this->Genre->id = $id;

		// try to change status from 1 to 0
		if ($this->Genre->saveField('status', 0)) {
			// delete the genre-dvd association from the join table
			// create the sql statement to remove association
			$sql = "DELETE FROM `dvds_genres` WHERE genre_id={$id}";

			// run the sql query
			$this->Genre->query($sql);

			// set flash message
			$this->Session->setFlash('The Genre was successfully deleted.', 'flash_good');
		} else {
			// set flash message
			$this->Session->setFlash('The Genre could not be deleted. Please try again.', 'flash_bad');
		}

		// redirect
		$this->redirect(array('action'=>'index'));
	}
	
	/**
	 * check_genre()
	 * will check that a genre is valid and exists in the db given an id
	 * this logic is used in a few actions so I put it in a function for reusability
	 */
	function _check_genre($id) {
		// if the id is null
		if (!$id) {
			// set flash message
			$this->Session->setFlash('Invalid id for Genre', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

		// find genre from db
		$genre = $this->Genre->read(null, $id);

		// check genre is not empty
		if(empty($genre)) {
			// set flash message
			$this->Session->setFlash('Invalid id for Genre', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

	return $genre;
	}
}

?>