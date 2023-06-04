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
            <label for="my-plugin-message">Enter Your Message:</label>
            <br><br>
            <input type="text" id="my-plugin-message" name="my_plugin_message" value="<?php echo esc_attr(get_option('my_plugin_message')); ?>">
            <br><br>
            <label for="my-plugin-location">Select Location:</label>
            <select id="my-plugin-location" name="my_plugin_location">
                <option value="both" <?php selected(get_option('my_plugin_location'), 'both'); ?>>Both (Header and Footer)</option>
                <option value="header" <?php selected(get_option('my_plugin_location'), 'header'); ?>>Header</option>
                <option value="footer" <?php selected(get_option('my_plugin_location'), 'footer'); ?>>Footer</option>
                <option value="none" <?php selected(get_option('my_plugin_location'), 'none'); ?>>None</option>
            </select>
            <br><br>
            <label for="my-plugin-blog-category">Select Blog Categories:</label>
            <select id="my-plugin-blog-category" name="my_plugin_blog_category[]" multiple>
                <option value="none" <?php selected(in_array('none', (array) get_option('my_plugin_blog_category')), true); ?>>None</option>
                <?php
                $blog_categories = get_categories();
                $selected_blog_categories = (array) get_option('my_plugin_blog_category', array());
                foreach ($blog_categories as $category) {
                    $selected = in_array($category->term_id, $selected_blog_categories);
                    echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($selected, true, false) . '>' . esc_html($category->name) . '</option>';
                }
                ?>
            </select>
            <br><br>
            <?php if (class_exists('WooCommerce')) : ?>
                <label for="my-plugin-product-category">Select Product Categories:</label>
                <select id="my-plugin-product-category" name="my_plugin_product_category[]" multiple>
                    <option value="none" <?php selected(in_array('none', (array) get_option('my_plugin_product_category')), true); ?>>None</option>
                    <?php
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                    ));
                    $selected_product_categories = (array) get_option('my_plugin_product_category', array());
                    foreach ($product_categories as $category) {
                        $selected = in_array($category->term_id, $selected_product_categories);
                        echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($selected, true, false) . '>' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
                <br><br>
            <?php endif; ?>
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

/** Register settings option */
function my_plugin_register_settings() {
    // Register the "my_plugin_message" setting
    register_setting('my-plugin-settings-group', 'my_plugin_message');

    // Register the "my_plugin_location" setting
    register_setting('my-plugin-settings-group', 'my_plugin_location');

    // Register the "my_plugin_blog_category" setting
    register_setting('my-plugin-settings-group', 'my_plugin_blog_category');

    // Register the "my_plugin_product_category" setting
    register_setting('my-plugin-settings-group', 'my_plugin_product_category');
}
add_action('admin_init', 'my_plugin_register_settings');


/** Header Message function */
function my_header_message() {
    // Check the selected location
    $location = get_option('my_plugin_location');

    // Get the selected blog categories
    $selected_blog_categories = get_option('my_plugin_blog_category', array());

    // Get the selected product categories
    $selected_product_categories = get_option('my_plugin_product_category', array());

    // Get the value of the "my_plugin_message" option
    $message = get_option('my_plugin_message');

    // Check if the message should be displayed in the header
    if (($location === 'header' || $location === 'both') && (!empty($message))) {
        // Check if the current page is a single post page in one of the selected blog categories,
        // or if no blog category is selected or if "None" blog category is selected
        if (
            (is_single() && has_category($selected_blog_categories)) ||
            (is_singular('product') && has_term($selected_product_categories, 'product_cat'))
        ) {
            // Output the message in the header or footer
            echo '<div class="header-message">' . esc_html($message) . '</div>';
        } elseif (
            empty($selected_blog_categories) ||
            in_array('none', (array) $selected_blog_categories) ||
            in_array('none', (array) $selected_product_categories)
        ) {
            // Output the message in the header or footer
            echo '<div class="header-message">' . esc_html($message) . '</div>';
        }
    }
}
add_action('wp_head', 'my_header_message');

/** Footer Message function */
function my_footer_message() {
    // Check the selected location
    $location = get_option('my_plugin_location');

    // Get the selected blog categories
    $selected_blog_categories = get_option('my_plugin_blog_category', array());

    // Get the selected product categories
    $selected_product_categories = get_option('my_plugin_product_category', array());

    // Get the value of the "my_plugin_message" option
    $message = get_option('my_plugin_message');

    // Check if the message should be displayed in the footer
    if (($location === 'footer' || $location === 'both') && (!empty($message))) {
        // Check if the current page is a single post page in one of the selected blog categories,
        // or if no blog category is selected or if "None" blog category is selected
        if (
            (is_single() && has_category($selected_blog_categories)) ||
            (is_singular('product') && has_term($selected_product_categories, 'product_cat'))
        ) {
            // Output the message in the header or footer
            echo '<div class="footer-message">' . esc_html($message) . '</div>';
        } elseif (
            empty($selected_blog_categories) ||
            in_array('none', (array) $selected_blog_categories) ||
            in_array('none', (array) $selected_product_categories)
        ) {
            // Output the message in the header or footer
            echo '<div class="footer-message">' . esc_html($message) . '</div>';
        }
    }
}
add_action('wp_footer', 'my_footer_message');
?>
