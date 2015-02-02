<?php
/**
 * AJAX Functions to handle each actions on the table of dish
 */

require_once( DM_PLUGIN_DIR . '/models/JSONError.php' );

/**
 * This function is called by Javascript in order to list all the stored types
 * It returns (more exactly print) a JSON object with a list of types
 * @see Type
 */
function listTypesCallback() {
	print ListTypes::getAllTypesJSON();
	die();
}

/**
 * This function is called by Javascript in order to save a type of dish (e.g starters, accompaniment, etc.)
 * It returns (more exactly print) a JSON object with the just saved type
 * Not used right
 * @see Type
 * @ignore
 */
function createTypeCallback() {
	$type = new Type();
	$type->setFromPOST($_POST);
	if (!$type->save()) {
		$error = new JSONError(__("Unable to save the type",DM_DOMAIN_NAME));
		print $error->getJSON();
		die();
	}
	print $type->getJSON();
	die();
}

/**
 * This function is called by Javascript in order to update a type of dish (e.g. starters, accompaniments, etc.)
 * It returns (more exactly print) a JSON object with the just saved type 
 * The parameter "id_type" is expected in the HTTP request and must correspond to the ID of an existing type
 * Not used right
 * @see Type
 * @ignore
 */
function updateTypeCallback() {
	$type = new Type($_POST["id_type"]);
	$type->setFromPOST($_POST);
	if (!$type->save()) {
		$error = new JSONError(__("Unable to save the type",DM_DOMAIN_NAME));
		print $error->getJSON();
		die();
	}
	print $type->getJSON();
	die();
}

/**
 * This function is called by Javascript in order to delete a type of dish
 * It returns (more exactly print) a JSON object with the just deleted type
 * The parameter "id_type" is expected in the HTTP request and must correspond to the ID of an existing type
 * Not used right
 * @see Type
 * @ignore
 */
function deleteTypeCallback() {
	$type = new Type($_POST["id_type"]);
	if (!$type->delete()) {
		$error = new JSONError(__("Unable to delete the type",DM_DOMAIN_NAME));
		print $error->getJSON();
		die();
	}
	print $type->getJSON();
	die();
}


/**
 * This function is called by Javascript in order to list dish types
 * It returns (more exactly print) a JSON object with a table of dish sub-types
 * @see Type
 */
function listSsTypesCallback() {
	$type = new Type($_GET["type"]);
	print $type->getSsTypesJSON();
	die();
}