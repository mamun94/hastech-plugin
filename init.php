<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();



function hp_plugin_enque_script(){
    // enqueue styles
    wp_enqueue_style( 'hpplugin-widgets', HP_PLUGIN_DIR_URL . 'assets/css/hp-widgets.css', true );

    // enqueue script
}
add_action( 'wp_enqueue_scripts','hp_plugin_enque_script');
