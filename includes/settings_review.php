<?php

 
/**
 * Custom settings for Google Reviews
 */
function google_review_display_settings() {
    // Register a new section in the "google_review" page
    add_settings_section(
        'settings_section',
        __('Settings', 'google_review'),
        null,
        'google_review'
    );
 
    // Register a new field for Place ID in the "settings_section" section, inside the "google_review" page
    add_settings_field(
        'google_place_id',
        __('Google Place ID', 'google_review'),
        'display_google_places_ID_element',
        'google_review',
        'settings_section'
    );
    // Register a new field for API Key in the "settings_section" section, inside the "google_review" page
    add_settings_field(
        'google_api_key',
        __('Google API Key', 'google_review'),
        'display_google_API_key_element',
        'google_review',
        'settings_section'
    );

    register_setting("settings_section", "google_place_id");
    register_setting("settings_section", "google_api_key");
}
 

function display_google_places_ID_element() {
	?>
    	<input type="text" size="40" name="google_place_id" id="google_place_id" value="<?php echo get_option('google_place_id'); ?>" />
    	
    	<p class="description">
    		A textual identifier that uniquely identifies a place, returned from a <a href="https://developers.google.com/places/place-id">Place Search</a>.
		</p>
    <?php
}

function display_google_API_key_element() {
	?>
    	<input type="text" size="40" name="google_api_key" id="google_api_key" value="<?php echo get_option('google_api_key'); ?>" />
	    
	    <p class="description">
	    	Your application's API key. This key identifies your application for purposes of quota management and so that places added from your application are made immediately available to your app. See <a href="https://developers.google.com/places/web-service/get-api-key" target="_blank"=>Get a key</a> for more information.
    	</p>
    <?php
}

