<?php
/*
 * Plugin Name: qTranslate Menu Item
 * Plugin URI: http://ekologik.se/arild
 * Description: Adds language switcher menu items to end of main menu.
 * Version: 0.1.1
 * Author: Arild <arild@ekologik.se>
 * Author URI: http://ekologik.se/arild
 * License: GPL2
 * Text Domain: langswitch-item
 */
// TODO Require qTranslate

load_plugin_textdomain( 'langswitch-item', false,
	dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if (!function_exists('langswitch_item')):
// TODO Use wp_get_nav_menu_items?
// http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items
function langswitch_item( $items, $args ) {
	global $q_config;
	// TODO Enable user to choose menu

	// Iterate through languages
	$langs = qtranxf_getSortedLanguages();
	// Select menu location to add switcher to
	if( $args->theme_location == 'primary')  { //<<<<<<<<<<---------- CHANGE MENU NAME HERE!
		foreach ($langs as $lang) {

			$url = (is_404()) ? get_option('home') : '';

			// Don't display for current language
			/*if ($lang == qtranxf_getLanguage())
				continue;*/

			// Prepare variables
			$URL = qtranxf_convertURL($url, $lang, false, true);
			// I wanted to do as below but it's ugly when language names are not translated
			//$title = sprintf(__('In %s', 'langswitch-item'),
			//  qtranxf_getLanguageName($lang));
			$title = $q_config['language_name'][$lang];

			// Modify output
			// TODO If exists, use function for menu link html
			$items .= sprintf('<li class="langswitch"><a href="%1$s" title="%2$s">%2$s</a></li>'."\n",
				$URL, $title);
		}
	}
	return $items;
}
endif;

add_filter('wp_nav_menu_items', 'langswitch_item', 10, 2);
