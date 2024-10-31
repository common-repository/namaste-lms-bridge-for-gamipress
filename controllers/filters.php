<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class NamasteGamFilters {
	/**
 * Register Namaste! LMS specific triggers
 *
 * @param array $triggers
 * @return mixed
 */ 
	static function register_triggers( $triggers ) {
		$namaste_triggers = array(
	        // Lessons
	        'namaste_gamipress_complete_lesson'                  => __( 'Complete a lesson', 'namaste-gamipress' ),
	        'namaste_gamipress_complete_specific_lesson'         => __( 'Complete a specific lesson', 'namaste-gamipress' ),
	        'namaste_gamipress_complete_lesson_specific_course'  => __( 'Complete a lesson of a specific course', 'namaste-gamipress' ),
	
	        // Courses
	        'namaste_gamipress_complete_course'          => __( 'Complete a course', 'namaste-gamipress' ),
	        'namaste_gamipress_complete_specific_course' => __( 'Complete a specific course', 'namaste-gamipress' ),
	    );
	    
	   if(NAMASTE_USE_MODULES) {
	   	 // Modules
       	 $namaste_triggers['namaste_gamipress_complete_module'] = __( 'Complete a module', 'namaste-gamipress' );
      	 $namaste_triggers['namaste_gamipress_complete_specific_module'] = __( 'Complete a specific module', 'namaste-gamipress' );
      	 $namaste_triggers['namaste_gamipress_complete_module_specific_course'] = __( 'Complete a mocule in a specific course', 'namaste-gamipress' );
	   }  
			
	   $triggers[__( 'Namaste! LMS', 'namaste-gamipress' )] = $namaste_triggers;

      return $triggers;
	} // end register_triggers
	
	/**
	 * Register Namaste! LMS specific activity triggers
	 *
	 * @since  1.0.0
	 *
	 * @param  array $specific_activity_triggers
	 * @return array
	 */
	static function register_specific_triggers( $specific_activity_triggers ) {
		 if(NAMASTE_USE_MODULES) {
		 	// Modules
	    	$specific_activity_triggers['namaste_gamipress_complete_specific_module'] = array( 'namaste_module' );
	    	$specific_activity_triggers['namaste_gamipress_complete_module_specific_course'] = array( 'namaste_course' );
		 }
	    	
	    // Lessons
	    $specific_activity_triggers['namaste_gamipress_complete_specific_lesson'] = array( 'namaste_lesson' );
	    $specific_activity_triggers['namaste_gamipress_complete_lesson_specific_course'] = array( 'namaste_course' );
	
	    // Courses
	    $specific_activity_triggers['namaste_gamipress_complete_specific_course'] = array( 'namaste_course' );
	
	    return $specific_activity_triggers;
	} // end register_specific_triggers
	
	/**
	 * Get user for a given trigger action.
	 *
	 * @since  1.0.0
	 *
	 * @param  integer $user_id user ID to override.
	 * @param  string  $trigger Trigger name.
	 * @param  array   $args    Passed trigger args.
	 * @return integer          User ID.
	 */
	static function trigger_get_user_id( $user_id, $trigger, $args ) {
	    switch ( $trigger ) {
	        // Modules
	        case 'namaste_gamipress_complete_module':
	        case 'namaste_gamipress_complete_specific_module':
	        case 'namaste_gamipress_complete_module_specific_course':
	
	        // Lessons
	        case 'namaste_gamipress_complete_lesson':
	        case 'namaste_gamipress_complete_specific_lesson':
	        case 'namaste_gamipress_complete_lesson_specific_course':
	
	        // Courses
	        case 'namaste_gamipress_complete_course':
	        case 'namaste_gamipress_complete_specific_course':
	            $user_id = $args[1];
	            break;
	    }
	
	    return $user_id;
	} // end trigger_get_user_id

	/**
	 * Extended meta data for event trigger logging
	 *
	 * @param array 	$log_meta
	 * @param integer 	$user_id
	 * @param string 	$trigger
	 * @param integer 	$site_id
	 * @param array 	$args
	 *
	 * @return array
	 */
	static function log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {
	
	    switch ( $trigger ) {
	        // Modules
	        case 'namaste_gamipress_complete_module':
	        case 'namaste_gamipress_complete_specific_module':
	        case 'namaste_gamipress_complete_module_specific_course':	        
	            // Add the module, lesson and course IDs
	            $log_meta['module_id'] = $args[0];
	            $log_meta['lesson_id'] = $args[2];
	            $log_meta['course_id'] = $args[3];
	        break;
	
	        // Lessons
	        case 'namaste_gamipress_complete_lesson':
	        case 'namaste_gamipress_complete_specific_lesson':
	        case 'namaste_gamipress_complete_lesson_specific_course':
	            $log_meta['lesson_id'] = $args[0];
	            $log_meta['course_id'] = $args[2];
	        break;
	
	        // Courses
	        case 'gamipress_ld_complete_course':
	        case 'gamipress_ld_complete_specific_course':	        
	            $log_meta['course_id'] = $args[0];
	        break;
	    }
	
	    return $log_meta;
	} // end log_even_trigger_meta_data
	
	/**
	 * Build custom activity trigger label
	 *
	 * @param string    $title
	 * @param integer   $requirement_id
	 * @param array     $requirement
	 *
	 * @return string
	 */
	static function activity_trigger_label( $title, $requirement_id, $requirement ) {
	    switch( $requirement['trigger_type'] ) {	
	        // Minimum grade events
	        case 'namaste_gamipress_complete_module':
	            return sprintf( __( 'Completed a module', 'namaste-gamipress' ), $score );
	        break;
	    }	
	    return $title;
	}	// end activity_trigger_label
	
	/**
	 * Register Namaste! LMS specific activity triggers labels
	 *
	 * @since  1.0.0
	 *
	 * @param  array $specific_activity_trigger_labels
	 * @return array
	 */
	static function specific_activity_trigger_label( $specific_activity_trigger_labels ) {
	    // Modules
	    $specific_activity_trigger_labels['namaste_complete_specific_module'] = __( 'Complete the module %s', 'namaste-gamipress' );
	    $specific_activity_trigger_labels['namaste_complete_module_specific_course'] = __( 'Complete a module of the course %s', 'namaste-gamipress' );
	
	    // Lessons
	    $specific_activity_trigger_labels['gamipress_ld_complete_specific_lesson'] = __( 'Complete the lesson %s', 'namaste-gamipress' );
	    $specific_activity_trigger_labels['gamipress_ld_complete_lesson_specific_course'] = __( 'Complete a lesson of the course %s', 'namaste-gamipress' );
	
	    // Courses
	    $specific_activity_trigger_labels['gamipress_ld_complete_specific_course'] = __( 'Complete the course %s', 'namaste-gamipress' );
	
	    return $specific_activity_trigger_labels;
	}
}