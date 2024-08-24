<?php
// Adds a menu item for the Social Share settings page.
function sss_admin_menu() {
    add_menu_page(
        'Social Share Settings',
        'Social Share',
        'manage_options',
        'social-share',
        'sss_settings_page',
        'dashicons-share',
        100
    );
}
add_action('admin_menu', 'sss_admin_menu');

/**
 * Renders the Social Share settings page.
 */
function sss_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Simple Social Share Settings', 'simple-social-share'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('social_share_settings_group');
            do_settings_sections('simple-social-share');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

?>