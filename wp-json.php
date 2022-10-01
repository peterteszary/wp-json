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
    
      if ( false === get_option( 'wp_json_info' ) ) {
  
          // Get all the api books.
          $info_nasa = get_json_data();
          
          // Save API call as a Transient.
          add_option( 'wp_json_info', $info_nasa );
  
          return;
      }
  
    // Custom Tables
    if ( false === get_option( 'wp_json_table_version' ) ) {
    //  create_database_table();
  }

  // Get the info stored in the database.
 // save_database_table_info();

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
   //This is what's new

   function create_database_table() {
    
      global $wp_json_table_version;
      global $wpdb;
  
      $wp_json_table_version = '1.0.0';
  
      $table_name = $wpdb->prefix . 'wp_json_table_version';
  
      $charset_collate = $wpdb->get_charset_collate();
  
     $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text(39),
        bookDescription text(116),
        contributor text(20),
        author text(20),
        price int(20),
        publisher text(20),
        PRIMARY KEY  (id)
     ) $charset_collate;";
  
     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
     dbDelta( $sql );
  
      // Save API call as a Transient.
      add_option( 'wp_json_table_version', $wp_json_table_version );
  }
  
  
  function save_database_table_info() {
  
      global $wpdb;
     
     $table_name = $wpdb->prefix . 'wp_json_table_version';
      
      $results = json_decode( get_option( 'wp_json_info_nasa' ) )->results;
  
      foreach( $results as $result ) {
  
          $wpdb->insert( 
              $table_name, 
              array( 
                  'time'            => current_time( 'mysql' ), 
                  'title'           => $result->title,
                  'bookDescription' => $result->description,
                  'contributor'     => $result->contributor,
                  'author'          => $result->author,
                  'price'           => $result->price,
                  'publisher'       => $result->publisher,
              ) 
          );
  
      }
  
  }

}
 //        $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position