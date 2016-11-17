<?php

/**
 * Top level menu
 */
function google_review_add_menu_page() {
    // Add top level menu page
    $hook = add_menu_page(
        'Google Reviews',
        'Google Reviews',
        'manage_options',
        'google_review',
        'google_review_settings_page'
    );
    // Run the callback function if the API Key or Place ID was created/updated.
    add_action('load-'.$hook,'google_review_do_on_settings_save');
}
 

 
function google_review_settings_page()
{
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
 
    // Add error/update messages
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('google_review_messages', 'google_review_message', __('Settings Saved', 'google_review'), 'updated');
    }
 
    // Show error/update messages
    settings_errors('google_review_messages');
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // Output security fields for the registered setting "google_review"
            settings_fields('settings_section');
            // Output setting sections and their fields
            // (sections are registered for "google_review", each field is registered to a specific section)
            do_settings_sections('google_review');
            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


