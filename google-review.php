<?php
/**
Plugin Name: Google Place Reviews
Plugin URI : 
Description: Pull in google reviews for a business and display them through a widget or some [custom_code].
Version:     1.0
Author:      Jana Rajkumar
Author URI:  www.jana19.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: review
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action') ){
	echo "Not allowed!";
	exit();
}

// Setup


// Includes
include( 'includes/activate.php' );
include( 'includes/deactivate.php' );
include( 'includes/custom_menu.php' );
include( 'includes/settings_review.php' );
include( 'includes/update_reviews.php' );
include( 'includes/short_code_reviews.php' );
include( dirname(__FILE__) . '/includes/widgets.php' );
include( 'includes/cron.php' );



// Hooks
register_activation_hook( __FILE__, 'google_review_activate_plugin' );
register_deactivation_hook( __FILE__, 'google_review_deactivate_plugin' );
add_action('admin_menu', 'google_review_add_menu_page');
add_action('admin_init', 'google_review_display_settings'); 
add_action('widgets_init', 'google_review_widgets_init');
add_action('google_review_daily_update_hook', 'google_review_daily_update');


// Shortcodes
add_shortcode( 'google_reviews', 'google_review_creator_shortcode');