<?php
require_once( DM_PLUGIN_DIR . '/models/Type.php' );
class ListTypes {

	public static function getAllTypesTable() {
		$result	= get_option(Type::getOptionId());
		
		return $result;
	}

	public static function getAllTypesJSON() {
		$rows = ListTypes::getAllTypesTable();
		
		// Array is decomposed into a table of options as described by jTable
		foreach ($rows as $id => $text) {
			$options[] = array(
					"DisplayText" => $text,
					"Value" => $id
			);
		}
		
		//Returns result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = $options;
	
		// Outputs the result
		return json_encode($jTableResult);
	}
	
}