<?php

// Insert new google reviews pulled from location API and insert into database
function google_review_do_on_settings_save()
{
	if(isset($_GET['settings-updated']) && $_GET['settings-updated']) {
		# Generate the json response for the google location
		$google_place_url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=";
		$api_key = get_option('google_api_key');
		$place_id = get_option('google_place_id');
		$response = wp_remote_get( $google_place_url.$place_id."&key=".$api_key );
		$body = json_decode( $response['body'] );

		// Check if there was en error processing the request
		if ( $body->status != "OK" ) {
			// There was an error while retreving the response
			debug_to_console( "ERROR HAPPENED" );
			add_action( 'admin_notices', 'google_review_error_notice' );
		}
		else {	
			// Get the reviews object form the response
			$reviews = $body->result->reviews;

			// Check if there are any reviews for this location
			if ( is_null($reviews) ) {
				add_action( 'admin_notices', 'google_review_no_reviews_notice' );
			}
			else {
				// Delete all previous reviews stored in our 'google_reviews' table
				global $wpdb;
				$deleteQuery = $wpdb->query("TRUNCATE TABLE `" . $wpdb->prefix . "google_reviews`");
				require( ABSPATH . '/wp-admin/includes/upgrade.php' );
				dbDelta( $deleteQuery );

				// Loop through each new review and add it to the 'google_reviews' table
				foreach ($reviews as $review) {
					$review_name = $review->author_name;
					$review_rating = $review->rating;
					$review_text = addslashes($review->text);
					$review_date = $review->time;

					debug_to_console( $review_name.$review_rating.$review_text.$review_date );

					$wpdb->insert(
						$wpdb->prefix . 'google_reviews',
						array(
							'review_name'		=>	$review_name,
							'review_rating'		=>	$review_rating,
							'review_text'		=>	$review_text,
							'review_date'		=>	date("Y-m-d\TH:i:s\Z", $review_date)
						)
					);
				}

				// Update the daily transients value 
				$reviews = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "google_reviews ORDER BY review_date DESC" );
				set_transient( 'google_review_widget_contents', $reviews, 60*60*24 );
			}
		}
	}
}


// The error message to display if unable to process the json request
function google_review_error_notice() {
    ?>
    <div class="error notice">
        <p><?php _e( 'ERROR: There was an error processing the request. Please verify your Place ID or API Key.', 'review' ); ?></p>
    </div>
    <?php
}


// The error message to display if there are no reviews for this location
function google_review_no_reviews_notice() {
    ?>
    <div class="error notice">
        <p><?php _e( 'Attention: There are no reviews available for the requested location.', 'review' ); ?></p>
    </div>
    <?php
}


// Used for testing purposes. It will print the passed in value to the console.
function debug_to_console( $data ) {
	$output = "<script>console.log( \"".$data."\" );</script>";
	echo $output;
}