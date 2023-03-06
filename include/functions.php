<?php

/** Menu pags function */
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
            <label for="my-plugin-enable-message">Enable message in footer</label>
            <input type="checkbox" id="my-plugin-enable-message" name="my_plugin_enable_message" <?php checked(get_option('my_plugin_enable_message'), 'on'); ?>>
            <br><br>
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
}
add_action( 'admin_init', 'my_plugin_register_settings' );


/** Footer Message function */
function my_footer_message() {
    
    // Check if the "my_plugin_enable_message" option is checked
    $enable_message = get_option('my_plugin_enable_message');

    if ( $enable_message == 'on' ) {
        // Get the value of the my_plugin_message option
        $message = get_option('my_plugin_message');

        // Output the message in the footer
        echo '<div class="footer-message">' . esc_html($message) . '</div>';
        var_dump($message);
    }

}
add_action('wp_footer', 'my_footer_message');