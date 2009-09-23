<?php

/**
 * file: app/model/format.php
 *
 * Format Model
 */
class Format extends AppModel {
	// good practice to include the name variable
	var $name = 'Format';

	// setup the has many relationships
	var $hasMany = array(
		'Dvd'=>array(
			'className'=>'Dvd'
		)
	);

	// setup form validation for formats
	var $validate = array(
		// name field
		'name' => array(
			// must not be empty
			'rule' 		=> VALID_NOT_EMPTY,
			// error message to display
			'message' 	=> 'Please enter a Format Name'
		)
	);
}

?>