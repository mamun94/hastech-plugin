<?php
/*
 * Plugin Name:       HasTech Plugin
 * Plugin URI:        https://example.com/plugins/hastech-plugin/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Kausar Al Mamun
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/hastech-plugin/
 * Text Domain:       hastech-plugin
 * Domain Path:       /languages
 */


 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Text Domain Load
function hastech_plugin_textdomian(){
    load_plugin_textdomain( 'hastech-plugin', false, dirname(__FILE__)."/languages" );
}
add_action("plugins_loaded",'hastech_plugin_textdomian');

// Define Constant
define('HP_PLUGIN_VERSION','1.0.0');
define('HP_PLUGIN_FILE',__FILE__);
define('HP_PLUGIN_PATH', plugin_dir_path(HP_PLUGIN_FILE));
define('HP_PLUGIN_DIR_URL', plugin_dir_url(HP_PLUGIN_FILE));
define('HP_PLUGIN_ASSETS', trailingslashit(HP_PLUGIN_DIR_URL . 'assets' ));

// Required File
require_once HP_PLUGIN_PATH . 'include/functions.php';

/**
 * Register a custom menu page.
 */
 add_action('admin_menu', 'my_menu_pages');
 function my_menu_pages(){
     add_menu_page( __('Setting','hastech-plugin') , __('Settings','hastech-plugin') , 'manage_options', 'hastech-plugin', 'my_menu', 'dashicons-admin-generic');
 }