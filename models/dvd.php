<?php

/**
 * file: app/model/dvd.php
 *
 * Dvd Model
 */
class Dvd extends AppModel {
	// good practice to include the name variable
	var $name = 'Dvd';

	// setup the belongs to relationships
	var $belongsTo = array(
		'Format'=>array(
			'className'	=>'Format',
			'conditions'=>'Format.status = 1'
		),
		'Type'=>array(
			'className'=>'Type',
			'conditions'=>'Type.status = 1'
		),
		'Location'=>array(
			'className'=>'Location',
			'conditions'=>'Location.status = 1'
		)
	);

    var $hasMany = array(
        'Loan' => array(
            'className' => 'Loan',
            'conditions' => array(
                'Loan.returned' => null
            )
        )
    );

	// setup the has and belongs to many relationship
	var $hasAndBelongsToMany = array(
		'Genre'=>array(
			'className' => 'Genre',
			'order'		=> 'name'
		)
	);

	// setup form validation for dvd
	var $validate = array(
		'name' => array(
			'rule' 		=> VALID_NOT_EMPTY,
			'message' 	=> 'Please enter a Dvd Name'
		),
		'genres' => array(
			'rule' 		=> VALID_NOT_EMPTY,
			'message' 	=> 'Please enter your Genres'
		)
	);
}

?>