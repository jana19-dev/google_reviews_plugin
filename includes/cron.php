<?php

function google_review_daily_update() {
	global $wpdb;

	$reviews = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "google_reviews ORDER BY review_date DESC" );

	// Expires after 1 day
	set_transient( 'google_review_widget_contents', $reviews, 60*60*24 );
}