<?php


function google_review_activate_plugin() {
	// Allow plugin to work only on wordpress version 4.2 or higher
	if ( version_compare( get_bloginfo('version'), '4.2', '<' ) ) {
		wp_die(__('You must update Wordpress to version 4.2 or higher', 'review') );
	}

	// Create the initial table to store all user reviews
	global $wpdb;
	$createSQL = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "google_reviews` (
  					`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  					`review_name` varchar(32) NOT NULL,
  					`review_rating` float(3,2) NOT NULL,
  					`review_text` text NOT NULL,
  					`review_date` datetime NOT NULL,
  					PRIMARY KEY (`id`)
				) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";

	require( ABSPATH . '/wp-admin/includes/upgrade.php' );
	dbDelta( $createSQL );


	// Schedule to run daily checks on new google reviews
	wp_schedule_event( time(), 'daily', 'google_review_daily_update_hook');

}



