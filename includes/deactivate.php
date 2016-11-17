<?php

function google_review_deactivate_plugin() {
	wp_clear_scheduled_hook( 'google_review_daily_update_hook' );
}