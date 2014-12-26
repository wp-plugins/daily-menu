<?php
require_once( DM_PLUGIN_DIR . '/models/Menu.php' );
require_once( DM_PLUGIN_DIR . '/models/Dish.php' );
abstract class ListMenus {
	
	/**
	 * Returns all the menu as an array
	 * @return array
	 */
	public static function getAllMenusTable() {
		global $wpdb;

		$result	= $wpdb->get_results(
			"SELECT menu.date as date, ".
			"	max(starter.id_dish) as id_starter, ".
			"	max(maincourse.id_dish) as id_maincourse, ".
			"	max(accompaniment.id_dish) as id_accompaniment, ".
			"	max(dairy.id_dish) as id_dairy, ".
			"	max(dessert.id_dish) as id_dessert ".
			"FROM ".$wpdb->prefix . Menu::getTableSuffix()." menu ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." starter ".
			"	on menu.id_dish = starter.id_dish and starter.type='".Dish::STARTER_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." maincourse ".
			"	on menu.id_dish = maincourse.id_dish and maincourse.type='".Dish::MAIN_COURSE_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." accompaniment ".
			"	on menu.id_dish = accompaniment.id_dish and accompaniment.type='".Dish::ACCOMPANIMENT_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dairy ".
			"	on menu.id_dish = dairy.id_dish and dairy.type='".Dish::DAIRY_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dessert ".
			"	on menu.id_dish = dessert.id_dish and dessert.type='".Dish::DESSERT_CODE."' ".
			"group by menu.date order by menu.date DESC"
		);
		
		return $result;
	}
	
	/**
	 * Returns all the menus as a JSON object
	 * @return string
	 */
	public static function getAllMenusJSON() {
		$rows = ListMenus::getAllMenusTable();
	
		//Returns result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
	
		// Outputs the result
		return json_encode($jTableResult);
	}
	
	/**
	 * This method returns a restricted number of menus, ordered as defined
	 * by the third argument $SQLsort, starting from record  $startIndex to
	 * a total of $pageSize records
	 * The result is an array.
	 * @param number $startIndex
	 * @param number $pageSize
	 * @param string $SQLsort
	 * @return array
	 */
	public static function getPagedMenusTable($startIndex,$pageSize,$SQLsort) {
		global $wpdb;
	
		$result	= $wpdb->get_results(
				"SELECT menu.date as date, ".
				"	max(starter.id_dish) as id_starter, ".
				"	max(maincourse.id_dish) as id_maincourse, ".
				"	max(accompaniment.id_dish) as id_accompaniment, ".
				"	max(dairy.id_dish) as id_dairy, ".
				"	max(dessert.id_dish) as id_dessert ".
				"FROM ".$wpdb->prefix . Menu::getTableSuffix()." menu ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." starter ".
				"	on menu.id_dish = starter.id_dish and starter.type='".Dish::STARTER_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." maincourse ".
				"	on menu.id_dish = maincourse.id_dish and maincourse.type='".Dish::MAIN_COURSE_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." accompaniment ".
				"	on menu.id_dish = accompaniment.id_dish and accompaniment.type='".Dish::ACCOMPANIMENT_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dairy ".
				"	on menu.id_dish = dairy.id_dish and dairy.type='".Dish::DAIRY_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dessert ".
				"	on menu.id_dish = dessert.id_dish and dessert.type='".Dish::DESSERT_CODE."' ".
				"group by menu.date ".
				(isset($SQLsort)?"ORDER BY " . $SQLsort . " ":" ").
				"LIMIT " . $startIndex . "," . $pageSize
		);
	
		return $result;
	}
	
	/**
	 * This method returns a restricted number of menus, ordered as defined
	 * by the third argument $SQLsort, starting from record  $startIndex to
	 * a total of $pageSize records
	 * The result is a JSON string.
	 * @param number $startIndex
	 * @param number $pageSize
	 * @param string $SQLsort
	 * @return string
	 */
	public static function getPagedMenusJSON($startIndex = 0,$pageSize = 20,$SQLsort = "date DESC") {
		$rows = ListMenus::getPagedMenusTable($startIndex,$pageSize,$SQLsort);
		$recordCount = ListMenus::getMenusCount();
		
		//Returns result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
	
		// Outputs the result
		return json_encode($jTableResult);
	}
	
	/**
	 * Gives the total number of menu in database
	 * @return number
	 */
	public static function getMenusCount() {
		global $wpdb;
		return $wpdb->get_var("SELECT count(distinct date) FROM ".$wpdb->prefix . Menu::getTableSuffix());
	}
	
	/**
	 * Returns the menus of the current week
	 * @return array
	 */
	public static function getWeekMenusTable() {
		global $wpdb;
	
		$result	= $wpdb->get_results(
			"SELECT menu.date as date, ".
			"	max(starter.id_dish) as id_starter, ".
			"	max(maincourse.id_dish) as id_maincourse, ".
			"	max(accompaniment.id_dish) as id_accompaniment, ".
			"	max(dairy.id_dish) as id_dairy, ".
			"	max(dessert.id_dish) as id_dessert ".
			"FROM ".$wpdb->prefix . Menu::getTableSuffix()." menu ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." starter ".
			"	on menu.id_dish = starter.id_dish and starter.type='".Dish::STARTER_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." maincourse ".
			"	on menu.id_dish = maincourse.id_dish and maincourse.type='".Dish::MAIN_COURSE_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." accompaniment ".
			"	on menu.id_dish = accompaniment.id_dish and accompaniment.type='".Dish::ACCOMPANIMENT_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dairy ".
			"	on menu.id_dish = dairy.id_dish and dairy.type='".Dish::DAIRY_CODE."' ".
			"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dessert ".
			"	on menu.id_dish = dessert.id_dish and dessert.type='".Dish::DESSERT_CODE."' ".
			"where EXTRACT(WEEK FROM menu.date) = EXTRACT(WEEK FROM CURRENT_DATE) ".
			"group by menu.date order by menu.date DESC"
		);
	
		return $result;
	}
	
	/**
	 * Returns the menus of the current week, as an array of Menu
	 * @see Menu
	 * @return Menu
	 */
	public static function getWeekMenus() {
		$menus = ListMenus::getWeekMenusTable();
		foreach ($menus as $menu) {
			$objectMenus [] = self::loadMenuFromResult($menu);
		}
		return $objectMenus;
	}
	
	/**
	 * Returns a string containing a HTML table of menus
	 * The menus are in colomn (that is to say day by day)
	 * Types of dish are in row
	 * @return string
	 */
	public static function getWeekMenusHTML() {
		$menus = ListMenus::getWeekMenus();
		if (!isset($menus)) {
			return (__("No menu this week !",DM_DOMAIN_NAME));
		}
		$types = ListTypes::getAllTypesTable();
		$html = "<table>";
		
		// header line with the days of the week
		$html .= "<tr>";
		$html .= "<th>".__("Day",DM_DOMAIN_NAME)."</th>";
		foreach (array_reverse($menus) as $menu) {
			$day = new DateTime($menu->getDate());
			$html .= "<th>".__($day->format("l"),DM_DOMAIN_NAME)."</th>";
		}
		$html .= "</tr>";
		
		// dish lines
		foreach ($types as $type => $typename) {
			$html .= "<tr>";
			$html .= "<th>".$typename."</th>";
			foreach (array_reverse($menus) as $menu) {
				$html .= "<td>".$menu->getDish($type)->getName()."</td>";
			}
			$html .= "</tr>";
		}
		$html .= "</table>";
		return $html;
	}
	
	/**
	 * Returns the coming next menu, assuming that the cut-off is at 4 PM
	 * @return array
	 */
	public static function getNextMenuRow() {
		global $wpdb;
	
		$result	= $wpdb->get_row(
				"SELECT menu.date as date, ".
				"	max(starter.id_dish) as id_starter, ".
				"	max(maincourse.id_dish) as id_maincourse, ".
				"	max(accompaniment.id_dish) as id_accompaniment, ".
				"	max(dairy.id_dish) as id_dairy, ".
				"	max(dessert.id_dish) as id_dessert ".
				"FROM ".$wpdb->prefix . Menu::getTableSuffix()." menu ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." starter ".
				"	on menu.id_dish = starter.id_dish and starter.type='".Dish::STARTER_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." maincourse ".
				"	on menu.id_dish = maincourse.id_dish and maincourse.type='".Dish::MAIN_COURSE_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." accompaniment ".
				"	on menu.id_dish = accompaniment.id_dish and accompaniment.type='".Dish::ACCOMPANIMENT_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dairy ".
				"	on menu.id_dish = dairy.id_dish and dairy.type='".Dish::DAIRY_CODE."' ".
				"left outer join ".$wpdb->prefix . Dish::getTableSuffix()." dessert ".
				"	on menu.id_dish = dessert.id_dish and dessert.type='".Dish::DESSERT_CODE."' ".
				"where ((DATEDIFF(menu.date,CURRENT_DATE) = 0) ".
				"   		and (TIME_TO_SEC(TIMEDIFF(160000,CURRENT_TIME)) >= 0)) ".
				"   or (DATEDIFF(menu.date,CURRENT_DATE) > 0) ".
				"group by menu.date order by menu.date ASC ".
				"limit 1");
	
		return $result;
	}
	
	/**
	 * Returns the comming next Menu, assuming that the cut-off is at 16 PM, or false if the is no menu
	 * @return Menu
	 */
	public static function getNextMenu() {
		$menu = ListMenus::getNextMenuRow();
		if (isset($menu)) {
			return self::loadMenuFromResult($menu);
		} else {
			return false;
		}
	}	
	
	/**
	 * 1. Sets the ID of each dish of the table result
	 * 2. Load each dish from DB to gets the name, composition, etc.
	 * @param array $menu
	 * @return Menu
	 */
	private static function loadMenuFromResult($menu) {
		$objectMenu = new Menu();
		$objectMenu->setDate($menu->date);
		$objectMenu->setStarter(new Dish($menu->id_starter));
		$objectMenu->setMainCourse(new Dish($menu->id_maincourse));
		$objectMenu->setAccompaniment(new Dish($menu->id_accompaniment));
		$objectMenu->setDairy(new Dish($menu->id_dairy));
		$objectMenu->setDessert(new Dish($menu->id_dessert));
		$objectMenu->load();
		return $objectMenu;
	}
	
}