<?php
/*
Plugin Name: Namaste! LMS Bridge for GamiPress
Plugin URI: 
Description: Connects GamiPress with Namaste! LMS and adds new activity events.
Author: Kiboko Labs
Author URI: https://namaste-lms.org
Text Domain: namaste-gamipress 
Version: 0.5
License: GPLv2 or later
*/

define( 'NAMASTEGAM_PATH', dirname( __FILE__ ) );
define( 'NAMASTEGAM_RELATIVE_PATH', dirname( plugin_basename( __FILE__ )));
define( 'NAMASTEGAM_URL', plugin_dir_url( __FILE__ ));

include(NAMASTEGAM_PATH.'/controllers/actions.php');
include(NAMASTEGAM_PATH.'/controllers/filters.php');


register_activation_hook( __FILE__, 'namastegam_activate' );
add_action('init', 'namastegam_init');
add_action('plugins_loaded', 'namastegam_loaded');

function namastegam_activate() {
	// let's not use this for now and see how things work only with using sessions	
	global $user_ID, $wpdb;
	namastegam_init();
		
	// create database tables or add DB fields
}

function namastegam_init() {
	global $wpdb;
	
	// typically you'll want to add at least jQuery
	wp_enqueue_script('jquery');  
}

function namastegam_loaded() {
	 // add actions
   add_action('namaste_completed_course', array('NamasteGamActions', 'completed_course'), 10, 2);
   add_action('namaste_completed_module', array('NamasteGamActions', 'completed_module'), 10, 2);
   add_action('namaste_completed_lesson', array('NamasteGamActions', 'completed_lesson'), 10, 2);
   
   // add filters
   add_filter( 'gamipress_activity_triggers', array('NamasteGamFilters', 'register_triggers') );
   add_filter( 'gamipress_specific_activity_triggers', array('NamasteGamFilters', 'register_specific_triggers')  );
   add_filter( 'gamipress_trigger_get_user_id', array('NamasteGamFilters', 'trigger_get_user_id'), 10, 3 );
   add_filter( 'gamipress_log_event_trigger_meta_data', array('NamasteGamFilters', 'log_event_trigger_meta_data'), 10, 5 );
   add_filter( 'gamipress_activity_trigger_label', array('NamasteGamFilters', 'activity_trigger_label'), 10, 3 );
   add_filter( 'gamipress_specific_activity_trigger_label', array('NamasteGamFilters', 'specific_activity_trigger_label') );
   
	$use_modules = get_option('namaste_use_modules');
	if(!defined('NAMASTE_USE_MODULES')) define('NAMASTE_USE_MODULES', $use_modules);   
}