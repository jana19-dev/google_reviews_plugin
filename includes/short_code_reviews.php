<?php

function google_review_creator_shortcode() {

	// Print a list of all latest google reviews (Google limits to 5)
	$output = '';

	$reviews = get_transient( 'google_review_widget_contents' );

	foreach ($reviews as $review) {
		$review_date = (new DateTime($review->review_date))->format('Y-M-d');
		$output .= '
		<p style="text-align: justify;">
			<strong>'. $review->review_name .'</strong>, rated <big>'.$review->review_rating.'</big>, on <small><strong>'. $review_date.'</strong></small>.<br>'.stripslashes($review->review_text).'<br> </p> ';
	}

	return $output;
}