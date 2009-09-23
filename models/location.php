<?php

/**
 * file: app/model/location.php
 *
 * Location Model
 */
class Location extends AppModel {
	// good practice to include the name variable
	var $name = 'Location';
	
	// setup the has many relationships
	var $hasMany = array(
		'Dvd'=>array(
			'className'=>'Dvd'
		)
	);

	// setup form validation for types
	var $validate = array(
		// name field
		'name' => array(
			// must not be empty
			'rule' 		=> VALID_NOT_EMPTY,
			// error message to display
			'message' 	=> 'Please enter a Location Name'
		)
	);
}

?>