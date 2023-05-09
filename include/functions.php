<?php

/** Menu pags function */
function my_menu(){
    // Get the selected categories
    $selected_categories = get_option('my_plugin_categories', array());

    // Get all available categories
    $categories = get_categories();
    ?>
    <div class="wrap">
        <h1>Plugin Settings</h1>
        <br>
        <form method="post" action="options.php">
            <?php
                settings_fields('my-plugin-settings-group'); // To display the hidden fields and handle security of your options form
                do_settings_sections('my-plugin-settings-group'); // Prints out all settings sections added to a particular settings page.
            ?>
            <label for="my-plugin-message">Enter your message:</label>
            <br><br>
            <input type="text" id="my-plugin-message" name="my_plugin_message" value="<?php echo esc_attr(get_option('my_plugin_message')); ?>">
            <br><br>
            <label for="my-plugin-enable-message">Enable Message</label>
            <input type="checkbox" id="my-plugin-enable-message" name="my_plugin_enable_message" <?php checked(get_option('my_plugin_enable_message'), 'on'); ?>>
            <br><br>

            <label for="my-plugin-categories">Select categories:</label><br><br>
            <?php foreach ($categories as $category) { ?>
                <input type="checkbox" id="my-plugin-category-<?php echo $category->slug; ?>" name="my_plugin_categories[]" value="<?php echo $category->slug; ?>" <?php checked(in_array($category->slug, $selected_categories)); ?>>
                <label for="my-plugin-category-<?php echo $category->slug; ?>"><?php echo $category->name; ?></label><br>
            <?php } ?>

            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}



/** Register settings option */
function my_plugin_register_settings() {
    // Register the "my_plugin_message" setting
    register_setting( 'my-plugin-settings-group', 'my_plugin_message' );
    // Register the "my_plugin_enable_message" setting
    register_setting( 'my-plugin-settings-group', 'my_plugin_enable_message' );
    // Register the "my_plugin_categories" setting
    register_setting( 'my-plugin-settings-group', 'my_plugin_categories' );
}
add_action( 'admin_init', 'my_plugin_register_settings' );



/*** Message Function ***/ 
function my_footer_message() {
    
    // Check if the "my_plugin_enable_message" option is checked
    $enable_message = get_option('my_plugin_enable_message');

    if ( is_category() ) {
        // Get the selected categories
        $selected_categories = get_option('my_plugin_categories', array());

        // Check if the current post's category is one of the selected categories
        $post_categories = get_the_category();
        $category_slugs = wp_list_pluck( $post_categories, 'slug' );
        if ( array_intersect( $category_slugs, $selected_categories ) ) {
            // Get the value of the my_plugin_message option
            $message = get_option('my_plugin_message');

            // Output the message in the footer
            echo '<div class="footer-message">' . esc_html($message) . '</div>';
        }
    } else {
        if ( $enable_message == 'on' ) {
            // Get the value of the my_plugin_message option
            $message = get_option('my_plugin_message');

            // Output the message in the footer
            echo '<div class="footer-message">' . esc_html($message) . '</div>';
        }
    }

}
add_action('wp_footer', 'my_footer_message');