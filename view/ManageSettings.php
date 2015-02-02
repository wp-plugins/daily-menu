<?php

if (!defined("DM_PLUGIN_DIR")) {
	define( 'DM_PLUGIN_DIR', 		WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
}

require_once( DM_PLUGIN_DIR . '/controllers/ListTypes.php');


wp_enqueue_script( 'jtable' ); // loads jquery and jtable as well as it has dependency on it
wp_enqueue_script( 'jtable.localization' ); // loads languages for Jtable
wp_enqueue_script( 'draw.type.table' );
//wp_enqueue_style( 'jtable.basic' );
wp_enqueue_style( 'jtable.blue' );
wp_enqueue_style( 'jtable.jquery-ui' );


echo "<h1>".__("Settings",DM_DOMAIN_NAME)."</h1>";

echo "<h2>".__("General options",DM_DOMAIN_NAME)."</h2>";

echo "<h3>".__("Manage sub-types of dish",DM_DOMAIN_NAME)."</p>";

echo '<p>';
echo '<div id="TypesTableContainer" style="width:90%"></div>';
echo '</p>';

echo "<h2>".__("Instructions for use",DM_DOMAIN_NAME)."</h2>";

echo "<p>".__("Daily menu provides facilities for canteen management.",DM_DOMAIN_NAME)."</p>";

echo "<p>".sprintf(
		__("In the \"%s\" menu, create several dishes that you will use later
				to compose your daily menu. Once this step is done, create
				day-to-day menus via \"%s\"",DM_DOMAIN_NAME),
		__("Dishes",DM_DOMAIN_NAME),
		__("Menus",DM_DOMAIN_NAME))."</p>";

echo "<p>".sprintf(__("Insert the following shortcode
				to dynamically show the menus of the week : %s.",DM_DOMAIN_NAME),
		"[dm_menu period=week]")."</p>";

echo "<p>".__("You can add a widget on your slide bar with the menu of the day,
		or the coming next menu, if it is 4 PM or after.",DM_DOMAIN_NAME)."</p>";

echo "<p>".__("Here are the coming next functionalities:",DM_DOMAIN_NAME);
echo "<ol>";
echo "<li>".__("a comprehensive page of general options to handle subtypes, css styles, language, etc.",DM_DOMAIN_NAME)."</li>";
echo "<li>".__("more options to the dm_menu shortcode",DM_DOMAIN_NAME)."</li>";
echo "<li>".__("handling of multi-menu per day",DM_DOMAIN_NAME)."</li>";
echo "<li>...</li>";
echo "</ol>";
echo "</p>";

echo "<p>".__("This plugin uses jTable (http://www.jtable.org/).",DM_DOMAIN_NAME)."</p>";