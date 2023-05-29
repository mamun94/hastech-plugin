<?php

/** Menu page function */
function my_menu(){
    ?>
    <div class="wrap">
        <h1>My Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('my-plugin-settings-group');
                do_settings_sections('my-plugin-settings-group');
            ?>
            <label for="my-plugin-message">Enter your message:</label>
            <br><br>
            <input type="text" id="my-plugin-message" name="my_plugin_message" value="<?php echo esc_attr(get_option('my_plugin_message')); ?>">
            <br><br>
            <label for="my-plugin-enable-default">Enable message by default:</label>
            <input type="checkbox" id="my-plugin-enable-default" name="my_plugin_enable_default" <?php checked(get_option('my_plugin_enable_default'), 'on'); ?>>
            <br><br>
            <label for="my-plugin-location">Select location:</label>
            <select id="my-plugin-location" name="my_plugin_location">
                <option value="both" <?php selected(get_option('my_plugin_location'), 'both'); ?>>Both (Header and Footer)</option>
                <option value="header" <?php selected(get_option('my_plugin_location'), 'header'); ?>>Header</option>
                <option value="footer" <?php selected(get_option('my_plugin_location'), 'footer'); ?>>Footer</option>
                <option value="none" <?php selected(get_option('my_plugin_location'), 'none'); ?>>None</option>
            </select>
            <br><br>
            <label for="my-plugin-category">Select categories:</label>
            <select id="my-plugin-category" name="my_plugin_category[]" multiple>
                <option value="none" <?php selected(in_array('none', get_option('my_plugin_category')), true); ?>>None</option>
                <?php
                $categories = get_categories();
                foreach ($categories as $category) {
                    $selected = in_array($category->term_id, get_option('my_plugin_category', array()));
                    echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($selected, true, false) . '>' . esc_html($category->name) . '</option>';
                }
                ?>
            </select>
            <br><br>
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

/** Register settings option */
function my_plugin_register_settings() {
    // Register the "my_plugin_message" setting
    register_setting('my-plugin-settings-group', 'my_plugin_message');

    // Register the "my_plugin_enable_default" setting
    register_setting('my-plugin-settings-group', 'my_plugin_enable_default');

    // Register the "my_plugin_location" setting
    register_setting('my-plugin-settings-group', 'my_plugin_location');

    // Register the "my_plugin_category" setting
    register_setting('my-plugin-settings-group', 'my_plugin_category');
}
add_action('admin_init', 'my_plugin_register_settings');


/** Header Message function */
function my_header_message() {
    // Check if the message is enabled
    $message_enabled = get_option('my_plugin_enable_default');

    // Check the selected location
    $location = get_option('my_plugin_location');

    // Get the selected categories
    $selected_categories = get_option('my_plugin_category', array());

    // Check if the message should be displayed in the header
    if ($message_enabled && ($location === 'header' || $location === 'both')) {
        // Check if the current page is a single post page in one of the selected categories,
        // or if no category is selected or if "None" category is selected
        if ((is_single() && (has_category($selected_categories) || empty($selected_categories))) || in_array('none', $selected_categories)) {
            // Get the value of the "my_plugin_message" option
            $message = get_option('my_plugin_message');

            // Output the message in the header
            echo '<div class="header-message">' . esc_html($message) . '</div>';
        }
    }
}
add_action('wp_head', 'my_header_message');


/** Footer Message function */
function my_footer_message() {
    // Check if the message is enabled
    $message_enabled = get_option('my_plugin_enable_default');

    // Check the selected location
    $location = get_option('my_plugin_location');

    // Get the selected categories
    $selected_categories = get_option('my_plugin_category', array());

    // Check if the message should be displayed in the footer
    if ($message_enabled && ($location === 'footer' || $location === 'both')) {
        // Check if the current page is a single post page in one of the selected categories,
        // or if no category is selected or if "None" category is selected
        if ((is_single() && (has_category($selected_categories) || empty($selected_categories))) || in_array('none', $selected_categories)) {
            // Get the value of the "my_plugin_message" option
            $message = get_option('my_plugin_message');

            // Output the message in the footer
            echo '<div class="footer-message">' . esc_html($message) . '</div>';
        }
    }
}
add_action('wp_footer', 'my_footer_message');




?>