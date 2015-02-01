<?php
/**
 * The "Type" class represents a type of dish, that is to say,
 * if the dish is a main course, a starter, dessert, dairy and a accompaniment.
 * All the types are stored in the wordpress option "dm_type_list"
 * @author laurent
 *
 */
class Type {
	
	private $id;
	private $text;
	const  OPTION_ID = "dm_type_list";
	
	/**
	 * The constructor of the dish class. Can be initialized with the code of a dish
	 * @param number $id
	 */
	function __construct($id = 0){
		$this->id = $id;
	}
	
	/**
	 * Getter of the code of the type
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Gets the text of the type
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Gives the name of the option used to store the types
	 * @return string
	 */
	public static function getOptionId() {
		return self::OPTION_ID;
	}
	
	/**
	 * Lists the subtypes of the type represented by this object
	 * @return mixed
	 */
	public function getSsTypesTable() {
		$type = get_option("dm_sstype_list");
		return $type[$this->id];
	}
	
	/**
	 * Retrieves the list of the sub type and serialize into a JSON object
	 * representing an option list, in accordance of jTable specs
	 * @return string
	 */
	public function getSsTypesOptionsJSON() {
		$rows = $this->getSsTypesTable();
		
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
	
	/**
	 * Retrieves the list of the sub type and serialize into a JSON object
	 * representing a result set
	 * @return string
	 */
	public function getSsTypesJSON() {
		$rows = $this->getSsTypesTable();
	
		//Returns result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
	
		// Outputs the result
		return json_encode($jTableResult);
	}
	
	
	/**
	 * Fill id and text type from a HTTP request
	 * @param array $args The post argument
	 */
	function setFromPOST($args) {
		$this->setId($args["id_type"]);
		$this->setText($args["text"]);
	}
	
	/**
	 * Sets the code of the type
	 * @param unknown $arg
	 */
	public function setId($arg) {
		$this->id = $arg;
	}
	
	/**
	 * Sets the text of the type
	 * @param unknown $arg
	 */
	public function setText($arg) {
		$this->text = $arg;
	}
	
	/**
	 * Saves the type
	 * TODO : complete stub
	 */
	public function save() {
		//$types = get_option(Type::OPTION_ID);
		//$types[] = 
		return;
	}
	
	
	/**
	 * Updates the type
	 * TODO : complete stub
	 */
	public function update() {
		return;
	}
	
	/**
	 * Encodes the type of dish into a JSON string
	 * @return string A JSON representing the type
	 */
	function getJSON() {
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = array("id_type" => $this->id,
				"text" => $this->text);
		return json_encode($jTableResult);
	}
	
}