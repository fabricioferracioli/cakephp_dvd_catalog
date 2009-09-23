<?php

/**
 * MiscHelper Class
 * has a few custom functions that are useful in a view
 *
 * file: /app/views/helpers/misc.php
 */
class MiscHelper extends AppHelper {
	
	/**
	 * display_errors()
	 * displays a list of errors given an array or just a string
	 */
	function display_errors($errors) {
		//init
		$output = '';
		$temp = '';

		// if an array
		if(is_array($errors)) {
			// loop through errors
			foreach($errors as $error) {
				$temp .= "<li>{$error}</li>";
			}
		} else {
			// save error
			$temp .= "<li>{$errors}</li>";
		}

		// build up div
		$output = "<ul class='flash_bad'>{$temp}</ul>";

	return $output;
	}
}

?>