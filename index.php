<?php
/*
 * Plugin Name: Daily Menu
* Plugin URI: https://wordpress.org/plugins/daily-menu/
* Description: Daily menu provides facilities for canteen management.
* Version: 0.1
* Author: L. Morretton
* License: GPL2
*/

/*  Copyright 2014  L. Morretton  (email : laurent(dot)morretton(at)gmail(dot)com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");

// Global definitions

define( 'DM_PLUGIN_DIR', 		WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'DM_DOMAIN_NAME','daily-menu');

// Imports

require_once( DM_PLUGIN_DIR . '/controllers/InstallController.php' );
require_once( DM_PLUGIN_DIR . '/controllers/ListDishes.php' );
require_once( DM_PLUGIN_DIR . '/controllers/ListTypes.php' );
require_once( DM_PLUGIN_DIR . '/controllers/ListMenus.php' );

require_once( DM_PLUGIN_DIR . '/controllers/MenuTableControlFunctions.php' );
require_once( DM_PLUGIN_DIR . '/controllers/DishTableControlFunctions.php' );

require_once( DM_PLUGIN_DIR . '/view/DailyMenuWidget.php' );

// Plugin managment functions (installation, activation, etc.)

function install_dm_plugin(){
	InstallController::install();
	InstallController::addSampleData();
}

function desactivate_dm_plugin(){
	InstallController::delete();
}

function uninstall_dm_plugin(){
}


// functions for menus on wordpress

function showManageDailyMenuWPContent(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} else {
		include(DM_PLUGIN_DIR.'/view/ManageSettings.php');
	}
}

function showManageDishesWPContent(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} else {
		include(DM_PLUGIN_DIR.'/view/ManageDishes.php');
	}
}

function showManageMenusWPContent(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} else {
		include(DM_PLUGIN_DIR.'/view/ManageMenus.php');
	}
}



function addDailyMenuWPMenu() {
	add_menu_page( __("Daily menu",DM_DOMAIN_NAME), __("Daily menu",DM_DOMAIN_NAME), 'manage_options', 'ManageDailyMenu', 'showManageDailyMenuWPContent', 'dashicons-list-view');
	add_submenu_page( 'ManageDailyMenu', __("Dishes",DM_DOMAIN_NAME), __("Dishes",DM_DOMAIN_NAME), 'manage_options', 'ManageDishes', 'showManageDishesWPContent');
	add_submenu_page( 'ManageDailyMenu', __("Menus",DM_DOMAIN_NAME), __("Menus",DM_DOMAIN_NAME), 'manage_options', 'ManageMenus', 'showManageMenusWPContent');
}



// Other function


function addDMStyles() {
	//wp_enqueue_style("jtable.basic",plugins_url("js/jtable/themes/basic/jtable_basic.css", __FILE__ ));
	wp_register_style("jtable.blue",plugins_url("js/jtable/themes/metro/blue/jtable.min.css", __FILE__ ));
	//wp_register_style("jtable.jquery-ui",plugins_url("js/jtable/themes/jqueryui/jtable_jqueryui.min.css", __FILE__ ));
	wp_register_style("jtable.jquery-ui",plugins_url("js/jtable/themes/jqueryui-redmond/jquery-ui.css", __FILE__ ));
	//wp_register_style("jtable.jquery-ui",plugins_url("js/jtable/themes/jqueryui-metroblue/jquery-ui.css", __FILE__ ));
	
}

function addDMScripts() {
//	wp_register_script( "jtable", plugins_url("js/jtable/jquery.jtable.js", __FILE__ ),
//			array("jquery-ui-core",
//				"jquery-ui-widget",
//				"jquery-ui-dialog"));
	wp_register_script( 'jtable', plugins_url("js/jtable/jquery.jtable.min.js", __FILE__ ),
		array( 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-position', 'jquery-ui-accordion',
			'jquery-ui-autocomplete', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-dialog',
			'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-effects-blind', 'jquery-effects-bounce',
			'jquery-effects-clip', 'jquery-effects-drop', 'jquery-effects-explode', 'jquery-effects-fade',
			'jquery-effects-fold', 'jquery-effects-highlight', 'jquery-effects-pulsate',
			'jquery-effects-scale', 'jquery-effects-shake', 'jquery-effects-slide',
			'jquery-effects-transfer', 'jquery-ui-menu', 'jquery-ui-progressbar', 'jquery-ui-resizable',
			'jquery-ui-selectable', 'jquery-ui-slider', 'jquery-ui-sortable', 'jquery-ui-spinner',
			'jquery-ui-tabs', 'jquery-ui-tooltip' ), '2.4.0' );

	// Attempt to load translation
	$jtableLibrary = plugins_url("js/jtable/localization/jquery.jtable.".substr(get_locale(),0,2).".js", __FILE__ );
	if (!is_404($jtableLibrary)) {
		wp_register_script( "jtable.localization", $jtableLibrary,array( 'jtable'));
	}	
	
	wp_register_script( "draw.dish.table", plugins_url("js/draw.dish.table.js", __FILE__ ), array("jtable"));
	wp_localize_script( 'draw.dish.table', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
	wp_localize_script( 'draw.dish.table','objectL10n', array(
		'table_title' => __("Dishes list",DM_DOMAIN_NAME),
		'column_name_title' => __("Name",DM_DOMAIN_NAME),
		'column_composition_title' => __("Composition",DM_DOMAIN_NAME),
		'column_type_title' => __("Type",DM_DOMAIN_NAME),
		'column_sstype_title' => __("Subtype",DM_DOMAIN_NAME),
		'column_picture_title' => __("Picture",DM_DOMAIN_NAME)
	));
	
	wp_register_script( "draw.menu.table", plugins_url("js/draw.menu.table.js", __FILE__ ), array("jtable"));
	wp_localize_script( 'draw.menu.table', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
	wp_localize_script( 'draw.menu.table','objectL10n', array(
		'table_title' => __("Menus list",DM_DOMAIN_NAME),
		'date_format' => __("yy-mm-dd",DM_DOMAIN_NAME),
		'column_date_title' => __("Date",DM_DOMAIN_NAME),
		'column_starter_title' => __("Starter",DM_DOMAIN_NAME),
		'column_maincourse_title' => __("Main Course",DM_DOMAIN_NAME),
		'column_accompaniment_title' => __("Accompaniment",DM_DOMAIN_NAME),
		'column_dairy_title' => __("Dairy",DM_DOMAIN_NAME),
		'column_dessert_title' => __("Dessert",DM_DOMAIN_NAME)
	));
	
}

function addDMWidget(){
	register_widget( 'DailyMenuWidget' );
}

// Ajax functions
// All ajax functions used by jTable are stored into controllers *TableControlFunctions.php

function listMenuShortcode( $atts ) {
	switch ($atts["period"]) {
		case "week":
			print ListMenus::getWeekMenusHTML();
			break;
		default : print ListMenus::getWeekMenusHTML();
	}

}


// Hooks registration

register_activation_hook( __FILE__, 'install_dm_plugin' );
register_deactivation_hook( __FILE__, 'desactivate_dm_plugin' );
register_uninstall_hook( __FILE__, 'uninstall_dm_plugin' );

add_action( 'admin_menu', 'addDailyMenuWPMenu' );
add_action( 'admin_enqueue_scripts', 'addDMStyles' );
add_action( 'admin_enqueue_scripts', 'addDMScripts' );
add_action( 'widgets_init', 'addDMWidget');

add_action( 'wp_ajax_list_dishes', 'listDishesCallback' );
add_action( 'wp_ajax_create_dish', 'createDishCallback' );
add_action( 'wp_ajax_update_dish', 'updateDishCallback' );
add_action( 'wp_ajax_delete_dish', 'deleteDishCallback' );

add_action( 'wp_ajax_list_menus', 'listMenusCallback' );
add_action( 'wp_ajax_create_menu', 'createMenuCallback' );
add_action( 'wp_ajax_update_menu', 'updateMenuCallback' );
add_action( 'wp_ajax_delete_menu', 'deleteMenuCallback' );

add_action( 'wp_ajax_list_dishes_from_type', 'listDishesFromTypeCallback' );

add_action( 'wp_ajax_list_types',  'listTypesCallback'  );
add_action( 'wp_ajax_list_sstypes','listSsTypesCallback');

load_plugin_textdomain('daily-menu', false, basename( dirname( __FILE__ ) ) . '/languages' );

add_shortcode( 'dm_menu', 'listMenuShortcode' );
