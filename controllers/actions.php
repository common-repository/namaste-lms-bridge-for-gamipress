<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class NamasteGamActions {
	static function completed_course($student_id, $course_id) {
		 // Complete any course
	    do_action( 'namaste_gamipress_complete_course', $course_id, $student_id, $course_id, array() );
	
	    // Complete specific course
	    do_action( 'namaste_gamipress_complete_specific_course',  $course_id, $student_id, $course_id, array() );
	}
	
	static function completed_module($student_id, $module_id) {
		$course_id = get_post_meta($module_id, "namaste_course", true);
		 
	    // Complete any module
	    do_action( 'namaste_gamipress_complete_module', $module_id, $student_id, $course_id, array() );
	
	    // Complete specific module
	    do_action( 'namaste_gamipress_complete_specific_module',  $module_id, $student_id, $course_id, array() );
	
	    if( $course_id !== 0 ) {
	        // Complete any module of a specific course
	        do_action( 'namaste_gamipress_complete_module_specific_course',  $module_id, $student_id, $course_id, array() );
	    }
	}
	
	static function completed_lesson($student_id, $lesson_id) {
		 $course_id = get_post_meta($lesson_id, "namaste_course", true);
		 
	    // Complete any lesson
	    do_action( 'namaste_gamipress_complete_lesson', $lesson_id, $student_id, $course_id, array() );
	
	    // Complete specific lesson
	    do_action( 'namaste_gamipress_complete_specific_lesson',  $lesson_id, $student_id, $course_id, array() );
	
	    if( $course_id !== 0 ) {
	        // Complete any lesson of a specific course
	        do_action( 'namaste_gamipress_complete_lesson_specific_course',  $lesson_id, $student_id, $course_id, array() );
	    }
	}
}