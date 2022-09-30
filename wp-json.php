<?php
/**
 * Plugin Name: WP-JSON
 * Plugin URI: https://purplepie.co
 * Author: Peter Teszáry
 * Author URI: https://peterteszary.com
 * Description: This is a simple JSON reader plugin
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: wp-json-reader
 */

 defined( 'ABSPATH') or die;

 // APP ID
 // Key
 // Secret

 add_action( 'admin_menu', 'wp_json_add_menu_page' );

 function wp_json_add_menu_page(){
    add_menu_page(
        'WP-JSON',
        'WP-JSON',
        'manage_option',
        'wp-json-reader',
        'get_json_data',
        'dashicons-book',
        16,
       
    );
 }

 function get_json_data(){
    echo 'wp-json loaded...',
 }
 //        $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position