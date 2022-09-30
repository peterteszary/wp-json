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

 add_action( 'admin_menu', 'wp_json_add_menu_page' );

 function wp_json_add_menu_page(){
   
    add_menu_page(
        'WP-JSON',
        'WP-JSON',
        'manage_options',
        'wp-json.php',
        'run_all_the_code_functions',
        'dashicons-book',
        16,
       
    );
 }

function run_all_the_code_functions() {
  
   if ( get_option('wp_json_info') ) {

      $results = json_decode( get_option( 'wp_json_info') )->results;

      echo '<pre>';
      var_dump(  $results);
      echo '</pre>';

      return;
   }
   print_r( 'The option is missing' );
   // Get all information
   $info_nasa = get_json_data();

   add_option( 'wp_json_info', $info_nasa );
 
   print_r( 'The option is saved' );
 
   // Get the information stored in the database
   // Transient

}

   

 function get_json_data(){

   $key = 'eBqHEXLlM87TdQuylLrVgPhRLhkyGbrBzlkKcJ0R';
   $url = "https://api.nasa.gov/planetary/apod?api_key=$key&offset=20";

   $args = array(
      'headers' => array(
         'Content-Type' => 'application/json',
      ),
      'body' => array(),
   );

   $response = wp_remote_get( $url, $args );
   
   $response_code = wp_remote_retrieve_response_code( $response );
   
   $body = wp_remote_retrieve_body( $response );

   var_dump( $response );

   if ( 401 === $response_code ) {
      return "Unauthorized access";
   }
   if ( 200 !== $response_code ) {
      return "Error in pinging API";

   if ( 200 === $response_code) {
      return $body;
   }   
   }

}
 //        $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position