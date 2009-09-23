<?php

/**
 * Dvds Controller
 *
 * file: /app/controllers/dvds_controller.php
 */
class DvdsController extends AppController {
	// good practice to include the name variable
	var $name = 'Dvds';

	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript', 'Misc', 'Time', 'Ajax');
    var $components = array('RequestHandler');

	// global ratings variable
	var $ratings;

    function __construct()
    {
        parent::__construct();
        $this->ratings = range(0, 10);
    }

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
	 * main index page for dvds
	 * url: /dvds/index
	 */
	function index() {
		// get all options for form
		$formats = $this->Dvd->Format->find('list', array(
			'fields' => 'id, name',
			'order'=>'Format.name',
			'conditions'=> array(
				'Format.status'=>'1'
			)
		));
		$types = $this->Dvd->Type->find('list', array(
			'fields'=>'id, name',
			'order'=>'Type.name',
			'conditions'=> array(
				'Type.status'=>'1'
			)
		));
		$locations = $this->Dvd->Location->find('list', array(
			'fields'=>'id, name',
			'order'=>'Location.name',
			'conditions'=> array(
				'Location.status'=>'1'
			)
		));
		$genres = $this->Dvd->Genre->find('list', array(
			'fields'=>'id, name',
			'order'=>'Genre.name',
			'conditions'=> array(
				'Genre.status'=>'1'
			)
		));

		// add name to option
		$formats 	= array(''=>'Formats') + $formats;
		$types	 	= array(''=>'Types') + $types;
		$locations 	= array(''=>'Locations') + $locations;
		$genres 	= array(''=>'Genres') + $genres;

		//pr($formats); pr($types); pr($locations); pr($genres);

		// if form submitted
		if (!empty($this->data)) {
			// if reset button pressed redirect to index page
			if(isset($this->data['reset'])) {
				$this->redirect(array('action'=>'index'));
			}

			// init
			$url = '';

			// remove search key if not set
			if($this->data['search'] == '') {
				unset($this->data['search']);
			}

			// loop through filters
			foreach($this->data as $key=>$filter) {
				// ignore submit button
				if($key != 'filter') {
					// init
					$selected = '';

					switch($key) {
						case 'format':
							$selected = $formats[$filter];
						break;
						case 'type':
							$selected = $types[$filter];
						break;
						case 'location':
							$selected = $locations[$filter];
						break;
						case 'genre':
							$selected = $genres[$filter];
						break;
						case 'search':
							$selected = $filter;
						break;
					}
					// if filter value is not empty
					if(!empty($filter)) {
						$selected = $this->slug($selected);
						$url .= "/$key/$selected";
					}
				}
			}

			// redirect
			$this->redirect('/dvds/index/'.$url);
		} else {
			// set form options
			$this->data['format'] = '';
			$this->data['type'] = '';
			$this->data['location'] = '';
			$this->data['genre'] = '';
			$this->data['search'] = '';
		}

		// if any parameters have been passed
		if(!empty($this->params['pass'])) {
			// only select active dvds
			$conditions = array('Dvd.status'=>1);

			// get params
			$params = $this->params['pass'];
			// loop
			foreach($params as $key=>$param) {
				// get the filter value
				if(isset($params[$key+1])) {
					$value = $params[$key+1];
				}

				// switch on param
				switch($param)
				{
					case 'format':
						// get format
						$format = $this->Dvd->Format->find('first', array(
							'recursive' => 0,
							'conditions' => array(
								'Format.slug'=>$value
							)
						));
						// set where clause
						$conditions['Dvd.format_id'] = $format['Format']['id'];
						// save value for form
						$this->data['format'] = $format['Format']['id'];
					break;
					case 'type':
						// get type
						$type = $this->Dvd->Type->find('first', array(
							'recursive' => 0,
							'conditions' => array(
								'Type.slug'=>$value
							)
						));
						// set where clause
						$conditions['Dvd.type_id'] = $type['Type']['id'];
						// save value for form
						$this->data['type'] = $type['Type']['id'];
					break;
					case 'location':
						// get type
						$location = $this->Dvd->Location->find('first', array(
							'recursive' => 0,
							'conditions' => array(
								'Location.slug'=>$value
							)
						));
						// set where clause
						$conditions['Dvd.location_id'] = $location['Location']['id'];
						// save value for form
						$this->data['location'] = $location['Location']['id'];
					break;
					case 'genre':
						// get genre
						$genre = $this->Dvd->Genre->find('first', array(
							'recursive' => 0,
							'conditions' => array(
								'Genre.slug'=>$value
							)
						));
						// save value for form
						$this->data['genre'] = $genre['Genre']['id'];
					break;
					case 'search':
						// setup like clause
						$conditions['Dvd.name LIKE'] = "%{$value}%";
						// save search string for form
						$this->data['search'] = str_replace('_', ' ', $value);
					break;
				}
			}

			//pr($conditions);

			// get all dvds with param conditions
			$dvds = $this->Dvd->find('all', array(
				'order'	=> 'Dvd.name',
				'conditions' => $conditions
			));

			// if genre filter has been set
			if(isset($genre)) {
				// loop through dvds
				foreach($dvds as $key=>$dvd) {
					// init
					$found = FALSE;
					// loop through genres
					foreach($dvd['Genre'] as $k=>$g) {
						// if the genre id matches the filter genre no need to continue
						if($g['id'] == $genre['Genre']['id']) {
							$found = TRUE;
							break;
						}
					}

					// if the genre was not found in dvds
					if(!$found) {
						// remove from list
						unset($dvds[$key]);
					}
				}
			}

		} else {
			// get all dvds from database where status = 1, order by name
			$dvds = $this->Dvd->find('all', array(
				'order'	=> 'Dvd.name',
				'conditions' => array(
					'Dvd.status'=>1
				)
			));
		}

		// set page title
		$this->pageTitle = 'CakeCatalog - Index Page';
		// set layout file
		$this->layout = 'index';
		// save the dvds in a variable for the view
		$this->set(compact('formats', 'types', 'locations', 'genres', 'dvds'));
	}

	/**
	 * view()
	 * displays a single dvd and all related info
	 * url: /dvds/view/dvd_slug
	 */
	function view($slug) {
		// if slug is null
		if(!$slug) {
			// set a flash message
			$this->Session->setFlash('Invalid slug for DVD', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}

		// find dvd in database
		$dvd = $this->Dvd->findBySlug($slug);
		// if dvd has been found
		if(!empty($dvd)) {
			// save genres string
			$dvd['Dvd']['genres'] = $this->_create_genre_string($dvd['Genre']);
			// set the dvd for the view
			$this->set('dvd', $dvd);

			// increment the number of items the dvd was viewed
			$this->Dvd->save(array(
				'Dvd' => array(
					'id' => $dvd['Dvd']['id'],
					'views' => ($dvd['Dvd']['views'] + 1)
				)
			));
		} else {
			// set a flash message
			$this->Session->setFlash('Invalid slug for DVD', 'flash_bad');
			// redirect user
			$this->redirect(array('action'=>'index'));
		}

		// set layout file
		$this->layout = 'view';
	}

	/**
	 * footer()
	 * gets dvds from db with passed url options
	 */
	function footer() {
		// if the data has been requested
		if(isset($this->params['requested'])) {
			// only get from dvd table
			$this->Dvd->recursive = -1;
			// return the dvds
			return $this->paginate();
		} else {
			// redirect to index
			$this->redirect(array('action'=>'index'));
		}
	}

	/**
	 * top_genres()
	 * gets the most active genres from the db
	 */
	function top_genres() {
		// if the data has been requested
		if(isset($this->params['requested'])) {
			// get all genres
			$genres = $this->Dvd->Genre->find('all');
			// init
			$sorted = array();
			// loop through
			foreach($genres as $key=>$g) {
				$sorted[$g['Genre']['slug']] = count($g['Dvd']);
			}
			// sort the array
			arsort($sorted);
			// return first 5 in array
			return array_slice($sorted, 0, 5);
		} else {
			// redirect to index
			$this->redirect(array('action'=>'index'));
		}
	}

	/**
	 * admin_index()
	 * main index page for admin users
	 * url: /admin/dvds/index
	 */
	function admin_index() {
		// get all dvds from database where status = 1, order by dvd name
		$dvds = $this->Dvd->findAll("Dvd.status=1", null, "Dvd.name");

		// save the dvds in a variable for the view
		$this->set('dvds', $dvds);
	}

	/**
	 * admin_add()
	 * allows an admin to add a dvd
	 * url: /admin/dvds/add
	 */
	function admin_add() {
		// if the form data is not empty
		if (!empty($this->data)) {
			// check for image
			$image_ok = $this->_upload_image();

			// if the image was uploaded successfully
			if($image_ok) {
				// initialise the Dvd model
				$this->Dvd->create();

				// create the slug
				$this->data['Dvd']['slug'] = $this->slug($this->data['Dvd']['name']);

				// check for a dvd with the same slug
				$dvd = $this->Dvd->find('first', array(
					'conditions' => array(
						'Dvd.slug'=>$this->data['Dvd']['slug'],
						'Dvd.status' => '1'
					)
				));

				// if slug is not taken
				if(empty($dvd)) {
					// save the genres to the form data array
					$this->data['Genre'] = $this->_parse_genres($this->data['Dvd']['genres']);
                    $this->data['Dvd']['image'] = substr($this->data['Dvd']['image'], 4);

					// try saving the dvd
					if($this->Dvd->save($this->data)) {
						// set a flash message
						$this->Session->setFlash('The DVD has been saved', 'flash_good');

						// redirect
						$this->redirect(array('action'=>'index'));
					} else {
						// set a flash message
						$this->Session->setFlash('The DVD could not be saved. Please, try again.', 'flash_bad');
					}
				} else {
					// set a flash message
					$this->Session->setFlash('The DVD could not be saved. The Name has already been taken.', 'flash_bad');
				}
			}
		}

		// find dvd options in a list format
		// new 1.2 feature, can also have 'count' and 'first'
		$formats 	= $this->Dvd->Format->find('list');
		$types 		= $this->Dvd->Type->find('list');
		$locations 	= $this->Dvd->Location->find('list');
		$ratings	= $this->ratings;

		// set the variables so they can be accessed from the view
		$this->set(compact('formats', 'types', 'locations', 'ratings'));
	}

	/**
	 * admin_edit()
	 * allows an admin to edit a dvd
	 * url: /admin/dvds/edit/id
	 */
	function admin_edit($id = null) {
		// if the id is null and the form data empty
		if (!$id && empty($this->data)) {
			// set a flash message
			$this->Session->setFlash('Invalid Dvd', 'flash_bad');
			// redirect the admin
			$this->redirect(array('action'=>'index'));
		}

		// find the dvd in the database
		$dvd = $this->Dvd->read(null, $id);

		// check for invalid id
		if(empty($dvd)) {
			// set a flash message
			$this->Session->setFlash('Invalid Dvd', 'flash_bad');
			// redirect the admin
			$this->redirect(array('action'=>'index'));
		}

		// if the form was submitted
		if (!empty($this->data)) {
			// check for image
			$image_ok = $this->_upload_image();

			// if the image was uploaded successfully
			if($image_ok) {
				// create the slug
				$this->data['Dvd']['slug'] = $this->slug($this->data['Dvd']['name']);

				// check for a dvd with the same slug
				$dvd = $this->Dvd->find('first', array(
					'conditions' => array(
						'Dvd.slug'=>$this->data['Dvd']['slug'],
						'Dvd.status' => '1'
					)
				));

				// if slug is not taken
				if(empty($dvd) || $dvd['Dvd']['id'] == $id) {

					// save the genres to the form data array
					$this->data['Genre'] = $this->_parse_genres($this->data['Dvd']['genres']);

					// try to save the Dvd
					if ($this->Dvd->save($this->data)) {
						// set a flash message
						$this->Session->setFlash('The Dvd has been saved', 'flash_good');
						// redirect the admin
						$this->redirect(array('action'=>'index'));
					} else {
						// set a flash message
						$this->Session->setFlash('The Dvd could not be saved. Please, try again.', 'flash_bad');
					}
				} else {
					// set a flash message
					$this->Session->setFlash('The DVD could not be saved. The Name has already been taken.', 'flash_bad');
				}
			}
		} else {
			// find the DVD from the database and save it in the data array
			$this->data = $dvd;
		}

		// save the string for the view
		$this->set('genres_str', $this->_create_genre_string($dvd['Genre']));

		// find dvd options from database in a list
		$formats 	= $this->Dvd->Format->find('list');
		$types 		= $this->Dvd->Type->find('list');
		$locations 	= $this->Dvd->Location->find('list');
		$ratings	= $this->ratings;

		$this->set(compact('formats','types','locations', 'ratings'));
	}

	/**
	 * admin_delete()
	 * allows an admin to delete a dvd
	 * url: /admin/dvds/delete/1
	 */
	function admin_delete($id = null) {
		// if the id is null
		if (!$id) {
			// set flash message
			$this->Session->setFlash('Invalid id for Dvd', 'flash_bad');
			// redirect
			$this->redirect(array('action'=>'index'));
		}

		// set the id of the dvd
		$this->Dvd->id = $id;

		// try to change status from 1 to 0
		if ($this->Dvd->saveField('status', 0)) {
			// delete the dvd-genre association from the join table
			// create the sql statement to remove association
			$sql = "DELETE FROM `dvds_genres` WHERE dvd_id={$id}";

			// run the sql query
			$this->Dvd->query($sql);

			// set flash message
			$this->Session->setFlash('The Dvd was successfully deleted.', 'flash_good');
		} else {
			// set flash message
			$this->Session->setFlash('The Dvd could not be deleted. Please try again.', 'flash_bad');
		}

		// redirect
		$this->redirect(array('action'=>'index'));
	}

	/**
	 * upload_image()
	 * private function to upload a file if it exists in the form
	 */
	function _upload_image() {
		// init
		$image_ok = TRUE;

		// if a file has been added
		if($this->data['File']['image']['error'] != 4) {
			// try to upload the file
			$result = $this->upload_files('img/dvds', $this->data['File']);

			// if there are errors
			if(array_key_exists('errors', $result)) {
				// set image ok to false
				$image_ok = FALSE;
				// set the error for the view
				$this->set('errors', $result['errors']);
			} else {
				// save the url
				$this->data['Dvd']['image'] = $result['urls'][0];
			}
		}

	return $image_ok;
	}

	/**
	 * _parse_genres()
	 * will parse a string of genres and get the id from the db,
	 * if genre doesn't exist this function will create it
	 */
	function _parse_genres($genres = null) {
		// variable to save genre data array
		$data = array();

		// explode the genres sepearated by a comma
		$explode = explode(',', $genres);

		// if the explode array is not empty
		if(!empty($explode)) {
			// loop through exploded genres
			foreach($explode as $genre) {
				// remove leading/trailing spaces
				$genre = trim($genre);

				// if the genre is not empty
				if(!empty($genre)) {
					// find the genre in the db
					$db_genre = $this->Dvd->Genre->find('first', array(
						'conditions' => array(
							'Genre.name' 	=> $genre,
							'Genre.status'	=> '1'
						)
					));

					// if a genre was found
					if(!empty($db_genre)) {
						// save the genre id
						$data[] = $db_genre['Genre']['id'];
					} else {
						// create a new genre
						$save = array('Genre'=>array(
							'name'	=> $genre,
							'slug'	=> $this->slug($genre),
							'status'=> 1
						));

						// create model
						// has to be done when adding multiple items in a row
						$this->Dvd->Genre->create();

						// save the new genre
						$saveOK = $this->Dvd->Genre->save($save);

						// if save was successful
						if($saveOK) {
							// last insert id
							$data[] = $this->Dvd->Genre->getLastInsertID();
						}
					}
				}
			}
		}

	return array('Genre' => $data);
	}

	/**
	 * _create_genre_string()
	 * will create a string of genres seperated by a single comma e.g. genre1, genre2, genre3,
	 */
	function _create_genre_string($genres) {
		// init
		$genre_string = '';

		// if genres array not empty
		if(!empty($genres)) {
			// loop through genres and save name as a string
			foreach($genres as $g) {
				$genre_string .= $g['name'].", ";
			}
		}

		// remove last comma
		$genre_string = substr($genre_string, 0, strrpos($genre_string, ','));

	return $genre_string;
	}
}

?>