<?php

/**
 * file: app/model/genre.php
 *
 * Genre Model
 */
class Genre extends AppModel {
	// good practice to include the name variable
	var $name = 'Genre';
	
	// setup the has and belongs to many relationship
	var $hasAndBelongsToMany = array(
		'Dvd'=>array(
			'className' => 'Dvd',
			'order'		=> 'name',
			'conditions'=> 'Dvd.status = 1'
		)
	);
	
	// setup form validation for genre
	var $validate = array(
		'name' => array(
			'rule' 		=> VALID_NOT_EMPTY,
			'message' 	=> 'Please enter a Genre Name'
		)
	);
}

?>