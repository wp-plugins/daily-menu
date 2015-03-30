<?php
if (!defined("DM_PLUGIN_DIR")) {
	define( 'DM_PLUGIN_DIR', 		WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
}

/**
 * This class can ben used to list and get selected themes
 * @author laurent
 *
 */
abstract class ListAdminThemes {
	
	const JQUERYUI_CSS_DIR = "js/jtable/themes";
	const JTABLE_CSS_DIR = "js/jtable/themes";
	
	/**
	 * List names of the files in the subdirectory "css"
	 * If no autorization to list files, then returns false
	 * @return boolean|multitype:mixed
	 */
	public static function getAvailableJQueryUiThemes() {
		$styles_dir = DM_PLUGIN_DIR . "/".JQUERYUI_CSS_DIR."/";
		
		$available = array ();

		$available[]="jqueryui/jtable_jqueryui.min.css";
		
		$available[]="jqueryui-redmond/jquery-ui.css";
		$available[]="jqueryui-metroblue/jquery-ui.css";
		
		return $available;
	}
	
	/**
	 * Gets the selected theme
	 * @return mixed
	 */
	public static function getSelectedJQueryUiTheme() {
		return get_option("dm_shotcode_jquery_css");
	}
	
	/**
	 * Gets the selected theme URL
	 * @return string
	 */
	public static function getSelectedJQueryUiThemeURL() {
		return JQUERYUI_CSS_DIR."/".ListAdminThemes::getSelectedJQueryUiTheme();
	}
	
	/**
	 * List names of the files in the subdirectory "css"
	 * If no autorization to list files, then returns false
	 * @return boolean|multitype:mixed
	 */
	public static function getAvailableJTableThemes() {
		$styles_dir = DM_PLUGIN_DIR . "/".JQUERYUI_CSS_DIR."/";
	
		$available = array ();
	
		$available[]="basic/jtable.min.css";
		
		$available[]="metro/blue/jtable.min.css";
		$available[]="metro/brown/jtable.min.css";
		$available[]="metro/crimson/jtable.min.css";
		$available[]="metro/darkgray/jtable.min.css";
		$available[]="metro/darkorange/jtable.min.css";
		$available[]="metro/green/jtable.min.css";
		$available[]="metro/lightgray/jtable.min.css";
		$available[]="metro/pink/jtable.min.css";
		$available[]="metro/purple/jtable.min.css";
		$available[]="metro/red/jtable.min.css";
		
		$available[]="lightcolor/blue/jtable.min.css";
		$available[]="lightcolor/gray/jtable.min.css";
		$available[]="lightcolor/green/jtable.min.css";
		$available[]="lightcolor/orange/jtable.min.css";
		$available[]="lightcolor/red/jtable.min.css";
		
		return $available;
	}
	
	/**
	 * Gets the selected theme
	 * @return mixed
	 */
	public static function getSelectedJTableTheme() {
		return get_option("dm_shotcode_jtable_css");
	}
	
	/**
	 * Gets the selected theme URL
	 * @return string
	 */
	public static function getSelectedJTableThemeURL() {
		return JTABLE_CSS_DIR."/".ListAdminThemes::getSelectedJTableTheme();
	}
	
}								