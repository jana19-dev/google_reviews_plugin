<?php

if ( !defined('WP_UNINSTALL_PLUGIN') ) {
	exit();
}

// Delete the table created during the activation of plugin. 
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . "google_reviews`" );